<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mosque extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'arabic_name',
        'address',
        'state',
        'phone',
        'email',
        'description',
        'logo',
        'is_active',
        'country',
        'timezone',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function prayerSchedules()
    {
        return $this->hasMany(PrayerSchedule::class);
    }

    public function families()
    {
        return $this->hasMany(Family::class);
    }

    public function santhas()
    {
        return $this->hasMany(Santha::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function settings()
    {
        return $this->hasOne(MosqueSetting::class);
    }
}