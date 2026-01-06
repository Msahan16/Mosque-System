<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class MosqueStaff extends Authenticatable
{
    use HasFactory;

    protected $table = 'mosque_staff';

    protected $fillable = [
        'mosque_id',
        'name',
        'username',
        'password',
        'email',
        'phone',
        'role',
        'is_active',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_login_at' => 'datetime',
    ];

    /**
     * Automatically hash password when setting
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the mosque that owns the staff
     */
    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    /**
     * Get the permissions for the staff
     */
    public function permissions()
    {
        return $this->hasMany(StaffPermission::class, 'staff_id');
    }

    /**
     * Check if staff has a specific permission
     */
    public function hasPermission($permissionKey)
    {
        return $this->permissions()->where('permission_key', $permissionKey)->exists();
    }

    /**
     * Check if staff has any of the given permissions
     */
    public function hasAnyPermission(array $permissions)
    {
        return $this->permissions()->whereIn('permission_key', $permissions)->exists();
    }

    /**
     * Get all permission keys as array
     */
    public function getPermissionKeys()
    {
        return $this->permissions()->pluck('permission_key')->toArray();
    }

    /**
     * Sync permissions for this staff member
     */
    public function syncPermissions(array $permissions)
    {
        // Delete existing permissions
        $this->permissions()->delete();

        // Create new permissions
        foreach ($permissions as $permission) {
            $this->permissions()->create([
                'permission_key' => $permission
            ]);
        }
    }

    /**
     * Check if this staff is an administrator
     */
    public function isAdministrator()
    {
        return false; // All staff members are now regular staff
    }
}
