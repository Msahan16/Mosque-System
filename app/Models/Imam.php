<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Imam extends Model
{
    protected $fillable = [
        'mosque_id',
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'qualification',
        'experience',
        'monthly_salary',
        'status',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'monthly_salary' => 'decimal:2',
    ];

    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(ImamFinancialRecord::class)->where('type', 'salary');
    }

    public function advancePayments(): HasMany
    {
        return $this->hasMany(ImamFinancialRecord::class)->where('type', 'advance');
    }

    public function financialRecords(): HasMany
    {
        return $this->hasMany(ImamFinancialRecord::class);
    }

    public function availableDays(): HasMany
    {
        return $this->hasMany(ImamAvailableDay::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getAvailableSalaryAttribute()
    {
        $currentMonth = now()->format('Y-m');
        
        // Get total advances for current month
        $monthlyAdvances = $this->advancePayments()
            ->where('status', 'paid')
            ->whereRaw("DATE_FORMAT(record_date, '%Y-%m') = ?", [$currentMonth])
            ->sum('amount');

        return (float)$this->monthly_salary - (float)$monthlyAdvances;
    }

    public function getNetSalaryAttribute()
    {
        return $this->available_salary;
    }
}
