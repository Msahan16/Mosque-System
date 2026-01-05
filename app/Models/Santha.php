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
        'months_covered',
        'months_data',
        'balance_due',
        'payment_applies_to',
        'month',
        'year',
        'payment_date',
        'payment_method',
        'receipt_number',
        'is_paid',
        'notes',
        'status',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'is_paid' => 'boolean',
        'months_data' => 'array',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    /**
     * Get formatted months covered display
     */
    public function getMonthsCoveredDisplay()
    {
        if (!$this->months_data || empty($this->months_data)) {
            return $this->month . ' ' . $this->year;
        }

        $months = collect($this->months_data)->map(function ($item) {
            $monthName = is_numeric($item['month']) 
                ? date('M', mktime(0, 0, 0, $item['month'], 1))
                : substr($item['month'], 0, 3);
            return $monthName . ' ' . $item['year'];
        })->join(', ');

        return $months;
    }

    /**
     * Check if this is a partial payment
     */
    public function isPartialPayment()
    {
        return $this->balance_due > 0;
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeColor()
    {
        if ($this->isPartialPayment()) {
            return 'orange';
        }
        return $this->status === 'paid' ? 'green' : 'red';
    }

    /**
     * Get display status
     */
    public function getDisplayStatus()
    {
        if ($this->isPartialPayment()) {
            return 'Partial (Due: ' . number_format($this->balance_due, 0) . ')';
        }
        return ucfirst($this->status);
    }
}
