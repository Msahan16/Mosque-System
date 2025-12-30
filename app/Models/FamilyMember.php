<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'name',
        'relation',
        'date_of_birth',
        'gender',
        'occupation',
        'education',
        'phone',
        'email',
        'notes',
        'status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth->age;
    }
}
