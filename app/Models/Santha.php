<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santha extends Model
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'family_id',
        'amount',
        'month',
        'year',
        'payment_date',
        'payment_method',
        'receipt_number',
        'is_paid',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'is_paid' => 'boolean',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}
