<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PorridgeSponsor extends Model
{
    protected $fillable = [
        'mosque_id',
        'ramadan_year',
        'day_number',
        'sponsor_name',
        'sponsor_phone',
        'sponsor_type',
        'porridge_count',
        'amount_per_porridge',
        'total_amount',
        'payment_status',
        'payment_method',
        'distribution_status',
        'distributed_at',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'ramadan_year' => 'integer',
        'day_number' => 'integer',
        'porridge_count' => 'integer',
        'amount_per_porridge' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'distributed_at' => 'datetime',
    ];

    // Relationships
    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function baithulmalTransaction()
    {
        return $this->hasOne(BaithulmalTransaction::class, 'reference_porridge_id');
    }

    // Accessors & Mutators
    public function getTotalAmountAttribute($value)
    {
        return $value ?? ($this->porridge_count * $this->amount_per_porridge);
    }

    public function getDisplayNameAttribute()
    {
        return $this->sponsor_name ?? 'Anonymous';
    }

    // Scopes
    public function scopeForMosque($query, $mosqueId)
    {
        return $query->where('mosque_id', $mosqueId);
    }

    public function scopeForYear($query, $year)
    {
        return $query->where('ramadan_year', $year);
    }

    public function scopeForDay($query, $day)
    {
        return $query->where('day_number', $day);
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    public function scopeDistributed($query)
    {
        return $query->where('distribution_status', 'distributed');
    }

    public function scopePending($query)
    {
        return $query->where('payment_status', 'pending');
    }
}
