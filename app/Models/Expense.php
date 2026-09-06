<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'template_id', 'expense_head_id', 'title', 'amount',
        'description', 'expense_date'
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'expense_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function expenseHead()
    {
        return $this->belongsTo(ExpenseHead::class);
    }

    public function distributions()
    {
        return $this->hasMany(ExpenseDistribution::class);
    }

    public function scopeForTemplate($query, $templateId)
    {
        return $query->where('template_id', $templateId);
    }
}
