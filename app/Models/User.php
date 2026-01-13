<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'mosque_id',
        'phone',
        'is_active',
        'status',
        'permissions',
        'board_role',
        'custom_board_role',
        'term_year',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
            'permissions' => 'array',
        ];
    }

    public function mosque()
    {
        return $this->belongsTo(Mosque::class);
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isMosque()
    {
        return $this->role === 'mosque';
    }

    /**
     * Check if user is staff
     */
    public function isStaff()
    {
        return $this->role === 'staff';
    }

    /**
     * Check if user has a specific permission
     */
    public function hasPermission($permission)
    {
        // Mosque admin users have all permissions
        if ($this->role === 'mosque') {
            return true;
        }

        // Check if staff has specific permission
        if ($this->isStaff() && $this->is_active && $this->permissions) {
            return in_array($permission, $this->permissions);
        }

        return false;
    }

    /**
     * Check if user has any of the given permissions
     */
    public function hasAnyPermission(array $permissions)
    {
        // Mosque admin users have all permissions
        if ($this->role === 'mosque') {
            return true;
        }

        // Check if staff has any of the permissions
        if ($this->isStaff() && $this->is_active && $this->permissions) {
            foreach ($permissions as $permission) {
                if (in_array($permission, $this->permissions)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Sync permissions for this staff member
     */
    public function syncPermissions(array $permissions)
    {
        $this->update(['permissions' => $permissions]);
    }

    /**
     * Get all permission keys as array
     */
    public function getPermissionKeys()
    {
        return $this->permissions ?? [];
    }
}
