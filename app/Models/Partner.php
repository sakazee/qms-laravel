<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'template_id', 'name', 'phone', 'address', 'notes'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function animalShares()
    {
        return $this->hasMany(AnimalShare::class);
    }

    public function animals()
    {
        return $this->belongsToMany(Animal::class, 'animal_shares')
                    ->withPivot('shares', 'share_amount', 'notes')
                    ->withTimestamps();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes
    public function scopeForTemplate($query, $templateId)
    {
        return $query->where('template_id', $templateId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Computed
    public function getTotalShareAmountAttribute(): float
    {
        return $this->animalShares()->sum('share_amount');
    }

    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->sum('amount');
    }

    public function getDueAmountAttribute(): float
    {
        return max(0, $this->total_share_amount - $this->total_paid);
    }

    public function getAdvanceAmountAttribute(): float
    {
        return max(0, $this->total_paid - $this->total_share_amount);
    }

    public function getPaymentStatusAttribute(): string
    {
        $due = $this->due_amount;
        if ($due <= 0) return 'paid';
        if ($this->total_paid > 0) return 'partial';
        return 'unpaid';
    }
}
