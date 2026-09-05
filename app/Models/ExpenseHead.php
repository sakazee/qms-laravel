<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseHead extends Model
{
    use HasFactory, SoftDeletes;

    public const COLORS = ['#059669', '#0284c7', '#d97706', '#e11d48', '#7c3aed', '#475569'];

    protected $fillable = [
        'user_id', 'name', 'description', 'color',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}