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
        'city',
        'state',
        'postal_code',
        'phone',
        'email',
        'description',
        'imam_name',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

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
}
