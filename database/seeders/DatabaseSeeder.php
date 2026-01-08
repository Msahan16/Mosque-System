<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mosque;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Donation;
use App\Models\Santha;
use App\Models\Student;
use App\Models\StudentPayment;
use App\Models\Ustad;
use App\Models\Imam;
use App\Models\ImamFinancialRecord;
use App\Models\PorridgeSponsor;
use App\Models\DailyPorridgeAllocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     * 
     * Default Login Credentials:
     * - Admin: admin@mosque.com / password: admin123
     * - Mosque User: masjid@example.com / password: masjid123
     * 
     * User Roles:
     * - Admin: System administrator managing all mosques
     * - Mosque: Individual mosque administrator
     */
    public function run(): void
    {
        // Create Admin User (System Management)
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@mosque.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'mosque_id' => null,
            'is_active' => true,
        ]);

        // Create Sample Mosque
        $mosque = Mosque::create([
            'name' => 'Al-Noor Masjid',
            'arabic_name' => 'مسجد النور',
            'address' => '123 Masjid Road',
            'state' => 'Colombo (Western)',
            'phone' => '011-2345678',
            'email' => 'info@alnoormasjid.com',
            'description' => 'A community mosque serving the local Muslim community with daily prayers and Islamic education.',
            'is_active' => true,
            'country' => 'Sri Lanka',
            'timezone' => 'Asia/Colombo',
            'latitude' => 6.9271,
            'longitude' => 80.7744,
        ]);

        // Create Mosque User
        User::create([
            'name' => 'Masjid Administrator',
            'email' => 'masjid@example.com',
            'password' => bcrypt('masjid123'),
            'role' => 'mosque',
            'mosque_id' => $mosque->id,
            'is_active' => true,
        ]);
    }
}
