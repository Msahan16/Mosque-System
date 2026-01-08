<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BaithulmalTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'type',
        'category',
        'description',
        'amount',
        'transaction_date',
        'payment_method',
        'reference_number',
        'reference_donation_id',
        'reference_santha_id',
        'reference_porridge_id',
        'reference_imam_record_id',
        'paid_to',
        'received_from',
        'notes',
        'attachments',
        'is_anonymous',
        'created_by',
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
        'is_anonymous' => 'boolean',
        'attachments' => 'array',
    ];

    /**
     * Get the mosque that owns the transaction.
     */
    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    /**
     * Get the user who created the transaction.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the donation that references this transaction.
     */
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class, 'reference_donation_id');
    }

    /**
     * Get the santha payment that references this transaction.
     */
    public function santha(): BelongsTo
    {
        return $this->belongsTo(Santha::class, 'reference_santha_id');
    }

    /**
     * Get the porridge sponsor that references this transaction.
     */
    public function porridge(): BelongsTo
    {
        return $this->belongsTo(PorridgeSponsor::class, 'reference_porridge_id');
    }

    /**
     * Get the imam financial record that references this transaction.
     */
    public function imamRecord(): BelongsTo
    {
        return $this->belongsTo(ImamFinancialRecord::class, 'reference_imam_record_id');
    }

    /**
     * Scope a query to only include income transactions.
     */
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    /**
     * Scope a query to only include expense transactions.
     */
    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    /**
     * Scope a query to filter by category.
     */
    public function scopeCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }
}
