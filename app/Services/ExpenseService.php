<?php

namespace App\Services;

use App\Models\Animal;
use App\Models\Expense;
use App\Models\ExpenseDistribution;
use Illuminate\Support\Facades\DB;

class ExpenseService
{
    /**
     * Create expense with auto-distribution
     * 
     * Distribution Types:
     * - flat: Equally split among all animals
     * - custom_percent: User-defined percentages per animal
     * - purchase_percent: Split proportional to purchase price
     */
    public function create(array $data, int $templateId, int $userId): Expense
    {
        return DB::transaction(function () use ($data, $templateId, $userId) {
            $expense = Expense::create([
                'user_id'           => $userId,
                'template_id'       => $templateId,
                'expense_head_id'   => $data['expense_head_id'] ?? null,
                'title'             => $data['title'],
                'amount'            => $data['amount'],
                'distribution_type' => $data['distribution_type'],
                'description'       => $data['description'] ?? null,
                'expense_date'      => $data['expense_date'],
            ]);

            $this->createDistributions($expense, $data, $templateId);

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
                'distribution_type' => $data['distribution_type'],
                'description'       => $data['description'] ?? null,
                'expense_date'      => $data['expense_date'],
            ]);

            // Delete old distributions and recreate
            $expense->distributions()->delete();
            $this->createDistributions($expense, $data, $expense->template_id);

            return $expense->fresh();
        });
    }

    private function createDistributions(Expense $expense, array $data, int $templateId): void
    {
        $animals = Animal::forTemplate($templateId)->get();

        if ($animals->isEmpty()) return;

        $distributions = [];

        switch ($expense->distribution_type) {
            case 'flat':
                $distributions = $this->flatDistribution($expense, $animals);
                break;

            case 'custom_percent':
                $distributions = $this->customPercentDistribution($expense, $data['distributions'] ?? []);
                break;

            case 'purchase_percent':
                $distributions = $this->purchasePercentDistribution($expense, $animals);
                break;
        }

        foreach ($distributions as $dist) {
            ExpenseDistribution::create($dist);
        }
    }

    private function flatDistribution(Expense $expense, $animals): array
    {
        $count = $animals->count();
        if ($count === 0) return [];

        $amountEach = round($expense->amount / $count, 2);
        $percent = round(100 / $count, 2);

        return $animals->map(fn($animal) => [
            'expense_id' => $expense->id,
            'animal_id'  => $animal->id,
            'percentage' => $percent,
            'amount'     => $amountEach,
        ])->toArray();
    }

    private function customPercentDistribution(Expense $expense, array $distributions): array
    {
        $result = [];
        foreach ($distributions as $animalId => $percent) {
            $result[] = [
                'expense_id' => $expense->id,
                'animal_id'  => $animalId,
                'percentage' => $percent,
                'amount'     => round($expense->amount * ($percent / 100), 2),
            ];
        }
        return $result;
    }

    private function purchasePercentDistribution(Expense $expense, $animals): array
    {
        $totalPurchase = $animals->sum('purchase_price');
        if ($totalPurchase == 0) {
            // Fallback to flat if no purchase prices
            return $this->flatDistribution($expense, $animals);
        }

        return $animals->map(fn($animal) => [
            'expense_id' => $expense->id,
            'animal_id'  => $animal->id,
            'percentage' => round(($animal->purchase_price / $totalPurchase) * 100, 2),
            'amount'     => round($expense->amount * ($animal->purchase_price / $totalPurchase), 2),
        ])->toArray();
    }

    public function validateCustomPercentTotal(array $distributions): bool
    {
        $total = array_sum($distributions);
        return abs($total - 100) < 0.01; // Allow tiny floating point errors
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
