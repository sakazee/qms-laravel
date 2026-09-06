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
     * Allocations must add up to the expense amount (rounding tolerance).
     * An empty template trivially passes.
     */
    public function validateAllocationTotal(array $data, $animals, float $total): bool
    {
        if ($animals->isEmpty()) return true;

        $allocated = collect($this->resolveRows($data, $animals, $total))->sum('amount');

        return abs((float) $allocated - $total) < 0.05;
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
    private function resolveRows(array $data, $animals, float $total): array
    {
        $rows = $data['distributions'] ?? [];
        $out  = [];

        foreach ($animals as $animal) {
            $row  = $rows[$animal->id] ?? [];
            $fill = $this->resolveRow($row, $total);
            if ($fill !== null) $out[$animal->id] = $fill;
        }

        return $out;
    }

    private function resolveRow(array $row, float $total): ?array
    {
        $percent = isset($row['percent']) && $row['percent'] !== '' ? (float) $row['percent'] : null;
        $amount  = isset($row['amount'])  && $row['amount']  !== '' ? (float) $row['amount']  : null;

        if ($percent !== null) {
            $pct = round($percent, 2);
            return [
                'method'     => 'percent',
                'percentage' => $pct,
                'amount'     => round($total * ($pct / 100), 2),
            ];
        }

        if ($amount !== null) {
            $amt = round($amount, 2);
            $pct = $total > 0 ? round($amt / $total * 100, 2) : 0;
            return [
                'method'     => 'amount',
                'percentage' => min($pct, 999.99),
                'amount'     => $amt,
            ];
        }

        return null;
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
