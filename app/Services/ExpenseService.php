<?php

namespace App\Services;

use App\Models\Animal;
use App\Models\Expense;
use App\Models\ExpenseDistribution;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    /**
     * Create expense with per-animal distribution
     *
     * Each selected animal row is expressed as either a percentage of the
     * total or a fixed amount. No selection means all template animals.
     */
    public function create(array $data, int $templateId, int $userId): Expense
    {
        return DB::transaction(function () use ($data, $templateId, $userId) {
            $expense = Expense::create([
                'user_id'         => $userId,
                'template_id'     => $templateId,
                'expense_head_id' => $data['expense_head_id'] ?? null,
                'title'           => $data['title'],
                'amount'          => $data['amount'],
                'split_type'      => $data['split_type'] ?? 'manual',
                'description'     => $data['description'] ?? null,
                'expense_date'    => $data['expense_date'],
            ]);

            $this->createDistributions($expense, $data, $templateId, $userId);

            return $expense;
        });
    }

    public function update(Expense $expense, array $data): Expense
    {
        return DB::transaction(function () use ($expense, $data) {
            $expense->update([
                'expense_head_id'   => $data['expense_head_id'] ?? null,
                'title'             => $data['title'],
                'amount'            => $data['amount'],
                'split_type'        => $data['split_type'] ?? 'manual',
                'description'       => $data['description'] ?? null,
                'expense_date'      => $data['expense_date'],
            ]);

            // Delete old distributions and recreate
            $expense->distributions()->delete();
            $this->createDistributions($expense, $data, $expense->template_id, $expense->user_id);

            return $expense->fresh();
        });
    }

    /**
     * Animals the expense applies to: the submitted selection, or all
     * animals of the template when nothing was selected. Unknown ids are
     * ignored.
     */
    public function targetAnimals(array $data, int $templateId, int $userId)
    {
        $all = Animal::forTemplate($templateId)->forUser($userId)->get();

        $selected = collect($data['animal_ids'] ?? [])
            ->filter(fn ($id) => $all->contains('id', (int) $id))
            ->map(fn ($id) => (int) $id);

        return $selected->isNotEmpty() ? $all->whereIn('id', $selected) : $all;
    }

    /**
     * Allocations must add up to the expense amount exactly. Percentage
     * rows are balanced (largest remainder) so fractional splits resolve
     * to exact paisa; genuinely mismatching amounts still get rejected.
     * An empty template trivially passes.
     */
    public function validateAllocationTotal(array $data, $animals, float $total): bool
    {
        if ($animals->isEmpty()) return true;

        $allocated = collect($this->resolveRows($data, $animals, $total))->sum('amount');

        return abs((float) $allocated - $total) < 0.001;
    }

    private function createDistributions(Expense $expense, array $data, int $templateId, int $userId): void
    {
        $animals = $this->targetAnimals($data, $templateId, $userId);
        if ($animals->isEmpty()) return;

        foreach ($this->resolveRows($data, $animals, (float) $expense->amount) as $animalId => $fill) {
            ExpenseDistribution::create([
                'expense_id' => $expense->id,
                'animal_id'  => $animalId,
                'method'     => $fill['method'],
                'percentage' => $fill['percentage'],
                'amount'     => $fill['amount'],
            ]);
        }
    }

    /**
     * Convert submitted per-animal rows into stored values. A row is a
     * percentage (amount derived from the total) or a fixed amount
     * (percentage derived). Rows with neither are skipped.
     */
    /**
     * Convert submitted per-animal rows into stored values. A row is a
     * percentage (amount derived from the total) or a fixed amount
     * (percentage derived). Rows with neither are skipped.
     *
     * Percentage rows are balanced by largest remainder (fractional
     * part), so the sum of ALL amounts is exactly the expense total –
     * never a paisa more or less. Fixed-amount rows keep their typed
     * value; if they alone leave a gap the validation rejects it.
     */
    private function resolveRows(array $data, $animals, float $total): array
    {
        $rows   = $data['distributions'] ?? [];
        $amount = [];
        $pct    = [];

        foreach ($animals as $animal) {
            $row  = $rows[$animal->id] ?? [];
            $fill = $this->parseRow($row, $total);

            if ($fill['percent'] !== null) {
                $p = round($fill['percent'], 2);
                $idealCents = ($total * $p / 100) * 100;
                $pct[$animal->id] = [
                    'pct'   => $p,
                    'cents' => (int) floor($idealCents + 1e-9),
                    'frac'  => $idealCents - floor($idealCents + 1e-9),
                ];
            } elseif ($fill['amount'] !== null) {
                $amt = round($fill['amount'], 2);
                $amount[$animal->id] = [
                    'amount'     => $amt,
                    'percentage' => $total > 0 ? min(round($amt / $total * 100, 2), 999.99) : 0,
                ];
            }
        }

        $totalCents = (int) round($total * 100);

        foreach ($amount as $id => $r) {
            $out[$id] = ['method' => 'amount', 'percentage' => $r['percentage'], 'amount' => $r['amount']];
        }

        if ($pct) {
            $usedCents  = array_reduce($amount, fn ($s, $r) => $s + (int) round($r['amount'] * 100), 0);
            $floorCents = array_sum(array_column($pct, 'cents'));

            $n         = count($pct);
            $remainder = $totalCents - $usedCents - $floorCents;

            if ($remainder > 0 && $remainder < $n) {
                uasort($pct, fn ($a, $b) => $b['frac'] <=> $a['frac']);
                foreach (array_slice($pct, 0, $remainder, true) as $id => $_) {
                    $pct[$id]['cents']++;
                }
            } elseif ($remainder < 0 && -$remainder <= $n) {
                uasort($pct, fn ($a, $b) => $a['frac'] <=> $b['frac']);
                foreach (array_slice($pct, 0, -$remainder, true) as $id => $_) {
                    $pct[$id]['cents']--;
                }
            } elseif ($remainder !== 0) {
                foreach ($pct as $id => $v) {
                    $pct[$id]['cents'] = (int) round($v['pct'] / 100 * $total * 100);
                }
            }

            foreach ($pct as $id => $v) {
                $out[$id] = [
                    'method'     => 'percent',
                    'percentage' => $v['pct'],
                    'amount'     => round($v['cents'] / 100, 2),
                ];
            }
        }

        ksort($out);

        return $out;
    }

    private function parseRow(array $row, float $total): array
    {
        $percent = isset($row['percent']) && $row['percent'] !== '' ? (float) $row['percent'] : null;
        $amount  = isset($row['amount'])  && $row['amount']  !== '' ? (float) $row['amount']  : null;

        return compact('percent', 'amount');
    }

    public function delete(Expense $expense): void
    {
        DB::transaction(function () use ($expense) {
            $expense->distributions()->delete();
            $expense->delete();
        });
    }

    public function getForTemplate(int $templateId, int $userId)
    {
        return Expense::with('distributions.animal', 'expenseHead')
                      ->forTemplate($templateId)
                      ->where('user_id', $userId)
                      ->latest()
                      ->get();
    }
}
