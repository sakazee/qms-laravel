<?php

namespace App\Services;

use App\Models\ExpenseHead;
use Illuminate\Support\Facades\Cache;

class ExpenseHeadService
{
    public function getAllForUser(int $userId)
    {
        return ExpenseHead::forUser($userId)->latest()->get();
    }

    public function create(array $data, int $userId): ExpenseHead
    {
        Cache::flush();
        return ExpenseHead::create(array_merge($data, ['user_id' => $userId]));
    }

    public function update(ExpenseHead $expenseHead, array $data): ExpenseHead
    {
        $expenseHead->update($data);
        Cache::flush();
        return $expenseHead->fresh();
    }

    public function delete(ExpenseHead $expenseHead): void
    {
        $expenseHead->delete();
        Cache::flush();
    }
}