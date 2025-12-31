<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ustad extends Model
{
    protected $fillable = [
        'mosque_id',
        'name',
        'phone',
        'email',
        'address',
        'specialization',
        'experience_years',
        'qualification',
        'salary',
        'joining_date',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'is_active' => 'boolean',
        'salary' => 'decimal:2',
        'experience_years' => 'integer',
    ];

    public function mosque(): BelongsTo
    {
        return $this->belongsTo(Mosque::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
