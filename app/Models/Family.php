<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'mosque_id',
        'family_id',
        'family_head_name',
        'family_head_profession',
        'phone',
        'email',
        'address',
        'total_members',
        'registration_date',
        'notes',
        'is_active',
        'family_income',
        'status',
    ];

    protected $casts = [
        'registration_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function members()
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function santhas()
    {
        return $this->hasMany(Santha::class);
    }
}
