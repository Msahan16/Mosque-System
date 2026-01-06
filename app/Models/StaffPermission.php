<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'permission_key',
    ];

    /**
     * Get the staff that owns the permission
     */
    public function staff()
    {
        return $this->belongsTo(MosqueStaff::class, 'staff_id');
    }

    /**
     * Available permissions in the system
     */
    public static function availablePermissions()
    {
        return [
            'dashboard' => 'Dashboard',
            'santha' => 'Santha Management',
            'students' => 'Student Management',
            'donations' => 'Donation Management',
            'porridge' => 'Porridge Management',
            'imam' => 'Imam Management',
            'ustad' => 'Ustad Management',
            'prayer_schedule' => 'Prayer Schedule',
            'families' => 'Family Management',
            'settings' => 'Mosque Settings',
            'reports' => 'Reports & Analytics',
        ];
    }
}
