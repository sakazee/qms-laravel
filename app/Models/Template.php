<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'name', 'year', 'description', 'status', 'is_default'];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function partners()
    {
        return $this->hasMany(Partner::class);
    }

    public function animalShares()
    {
        return $this->hasMany(AnimalShare::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    // Computed attributes
    public function getTotalAnimalCostAttribute(): float
    {
        return $this->animals()->sum('purchase_price');
    }

    public function getTotalExpenseAttribute(): float
    {
        return $this->expenses()->sum('amount');
    }

    public function getTotalCollectionAttribute(): float
    {
        return $this->payments()->sum('amount');
    }

    public function getTotalCostAttribute(): float
    {
        return $this->total_animal_cost + $this->total_expense;
    }

    public function getDueAttribute(): float
    {
        return max(0, $this->total_cost - $this->total_collection);
    }

    public function getAdvanceAttribute(): float
    {
        return max(0, $this->total_collection - $this->total_cost);
    }
}
