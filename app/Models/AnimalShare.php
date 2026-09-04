<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalShare extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'template_id', 'animal_id',
        'partner_id', 'shares', 'share_amount', 'notes'
    ];

    protected $casts = [
        'shares'       => 'integer',
        'share_amount' => 'decimal:2',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
}
