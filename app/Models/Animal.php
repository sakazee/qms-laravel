<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'template_id', 'type', 'name',
        'total_shares', 'purchase_price', 'status', 'notes'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'total_shares'   => 'integer',
    ];

    // Large animals can have up to 7 shares; small animals only 1
    public const LARGE_ANIMALS = ['cow', 'buffalo', 'camel'];
    public const SMALL_ANIMALS = ['goat', 'sheep', 'other'];

    public const MAX_SHARES_LARGE = 7;
    public const MAX_SHARES_SMALL = 1;

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

    public function partners()
    {
        return $this->belongsToMany(Partner::class, 'animal_shares')
                    ->withPivot('shares', 'share_amount', 'notes')
                    ->withTimestamps();
    }

    public function expenseDistributions()
    {
        return $this->hasMany(ExpenseDistribution::class);
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
    public function getIsLargeAttribute(): bool
    {
        return in_array($this->type, self::LARGE_ANIMALS);
    }

    public function getMaxSharesAttribute(): int
    {
        return $this->is_large ? self::MAX_SHARES_LARGE : self::MAX_SHARES_SMALL;
    }

    public function getAssignedSharesAttribute(): int
    {
        return $this->animalShares()->sum('shares');
    }

    public function getAvailableSharesAttribute(): int
    {
        return $this->total_shares - $this->assigned_shares;
    }

    public function getSharePriceAttribute(): float
    {
        if ($this->total_shares === 0) return 0;
        return $this->purchase_price / $this->total_shares;
    }

    public function getTypeNameAttribute(): string
    {
        return match($this->type) {
            'cow'     => __('animals.type.cow'),
            'buffalo' => __('animals.type.buffalo'),
            'camel'   => __('animals.type.camel'),
            'goat'    => __('animals.type.goat'),
            'sheep'   => __('animals.type.sheep'),
            default   => __('animals.type.other'),
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending'      => 'warning',
            'purchased'    => 'info',
            'slaughtered'  => 'success',
            default        => 'secondary',
        };
    }
}
