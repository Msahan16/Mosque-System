<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImamAvailableDay extends Model
{
    protected $fillable = [
        'imam_id',
        'mosque_id',
        'day_of_week',
        'is_available',
        'specific_date',
        'start_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'specific_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function imam(): BelongsTo
    {
        return $this->belongsTo(Imam::class);
    }

    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }

    public function scopeByDay($query, $day)
    {
        return $query->where('day_of_week', $day);
    }
}
