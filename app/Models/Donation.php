<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'family_id',
        'donor_name',
        'donor_phone',
        'donor_email',
        'amount',
        'donation_type',
        'payment_method',
        'receipt_number',
        'donation_date',
        'purpose',
        'notes',
        'is_anonymous',
        'status',
        'transaction_type',
    ];

    protected $casts = [
        'donation_date' => 'date',
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function baithulmalTransaction()
    {
        return $this->hasOne(BaithulmalTransaction::class, 'reference_donation_id');
    }
}
