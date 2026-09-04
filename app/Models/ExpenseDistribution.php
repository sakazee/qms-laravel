<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseDistribution extends Model
{
    protected $fillable = ['expense_id', 'animal_id', 'percentage', 'amount'];

    protected $casts = [
        'percentage' => 'decimal:2',
        'amount'     => 'decimal:2',
    ];

    public function expense()
    {
        return $this->belongsTo(Expense::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
