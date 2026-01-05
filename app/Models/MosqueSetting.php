<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MosqueSetting extends Model
{
    use HasFactory;

    protected $table = 'mosque_settings';

    protected $fillable = [
        'mosque_id',
        'santha_amount',
        'santha_collection_date',
        'porridge_amount',
        'notes',
        'fajr_iqamah_offset',
        'dhuhr_iqamah_offset',
        'asr_iqamah_offset',
        'maghrib_iqamah_offset',
        'isha_iqamah_offset',
    ];

    protected $casts = [
        'santha_amount' => 'decimal:2',
        'porridge_amount' => 'decimal:2',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
