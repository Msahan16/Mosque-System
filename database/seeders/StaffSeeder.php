<?php

namespace Database\Seeders;

use App\Models\Mosque;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first mosque
        $mosque = Mosque::first();

        if ($mosque) {
            // Create a staff member for santha collection
            User::create([
                'mosque_id' => $mosque->id,
                'name' => 'Santha Collector',
                'email' => 'santha.staff@example.com',
                'password' => 'password', // Will be hashed automatically via 'hashed' cast
                'phone' => '0772345678',
                'role' => 'staff',
                'is_active' => true,
                'permissions' => ['dashboard', 'santha'],
            ]);

            // Create a staff member for donations
            User::create([
                'mosque_id' => $mosque->id,
                'name' => 'Donation Manager',
                'email' => 'donation.staff@example.com',
                'password' => 'password',
                'phone' => '0773456789',
                'role' => 'staff',
                'is_active' => true,
                'permissions' => ['dashboard', 'donations'],
            ]);

            // Create a staff member for porridge
            User::create([
                'mosque_id' => $mosque->id,
                'name' => 'Porridge Manager',
                'email' => 'porridge.staff@example.com',
                'password' => 'password',
                'phone' => '0774567890',
                'role' => 'staff',
                'is_active' => true,
                'permissions' => ['dashboard', 'porridge'],
            ]);
        }
    }
}
