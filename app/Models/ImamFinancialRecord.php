<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImamFinancialRecord extends Model
{
    protected $fillable = [
        'imam_id',
        'mosque_id',
        'type',
        'amount',
        'record_date',
        'payment_date',
        'payment_method',
        'transaction_id',
        'notes',
        'status',
        'basic_salary',
        'house_allowance',
        'transport_allowance',
        'medical_allowance',
        'other_allowances',
        'purpose',
        'reason',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'record_date' => 'date',
        'payment_date' => 'date',
        'basic_salary' => 'decimal:2',
        'house_allowance' => 'decimal:2',
        'transport_allowance' => 'decimal:2',
        'medical_allowance' => 'decimal:2',
        'other_allowances' => 'decimal:2',
    ];

    public function imam(): BelongsTo
    {
        return $this->belongsTo(Imam::class);
    }

    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    public function baithulmalTransaction()
    {
        return $this->hasOne(BaithulmalTransaction::class, 'reference_imam_record_id');
    }

    // Scopes for different types
    public function scopeSalaries($query)
    {
        return $query->where('type', 'salary');
    }

    public function scopeAdvances($query)
    {
        return $query->where('type', 'advance');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    // Accessor for total salary calculation
    public function getTotalSalaryAttribute()
    {
        if ($this->type === 'salary') {
            return ((float)($this->basic_salary ?? 0)) +
                   ((float)($this->house_allowance ?? 0)) +
                   ((float)($this->transport_allowance ?? 0)) +
                   ((float)($this->medical_allowance ?? 0)) +
                   ((float)($this->other_allowances ?? 0));
        }
        return $this->amount;
    }
}
