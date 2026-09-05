<?php

namespace App\Policies;

use App\Models\ExpenseHead;
use App\Models\User;

class ExpenseHeadPolicy
{
    public function view(User $user, ExpenseHead $expenseHead): bool
    {
        return $user->id === $expenseHead->user_id;
    }

    public function update(User $user, ExpenseHead $expenseHead): bool
    {
        return $user->id === $expenseHead->user_id;
    }

    public function delete(User $user, ExpenseHead $expenseHead): bool
    {
        return $user->id === $expenseHead->user_id;
    }
}