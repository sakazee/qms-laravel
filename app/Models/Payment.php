<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'template_id', 'partner_id', 'amount',
        'payment_date', 'payment_method', 'reference', 'notes'
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'payment_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function scopeForTemplate($query, $templateId)
    {
        return $query->where('template_id', $templateId);
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'cash'          => __('payments.method.cash'),
            'bank'          => __('payments.method.bank'),
            'mobile_banking'=> __('payments.method.mobile_banking'),
            default         => __('payments.method.other'),
        };
    }
}
