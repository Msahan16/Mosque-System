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
        'notes',
    ];

    protected $casts = [
        'santha_amount' => 'decimal:2',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }
}
