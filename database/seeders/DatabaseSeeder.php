<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Mosque;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Donation;
use App\Models\Santha;
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
        User::create([
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
            'city' => 'Colombo',
            'state' => 'Western Province',
            'postal_code' => '00100',
            'phone' => '011-2345678',
            'email' => 'info@alnoormasjid.com',
            'description' => 'A community mosque serving the local Muslim community with daily prayers and Islamic education.',
            'imam_name' => 'Sheikh Abdul Rahman',
            'is_active' => true,
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

        // Create Sample Families
        $family1 = Family::create([
            'mosque_id' => $mosque->id,
            'family_head_name' => 'Ahmed Hassan',
            'phone' => '077-1234567',
            'alternate_phone' => '011-9876543',
            'email' => 'ahmed.hassan@example.com',
            'address' => '45 Main Street',
            'city' => 'Colombo',
            'state' => 'Western Province',
            'postal_code' => '00200',
            'total_members' => 4,
            'registration_date' => now()->subMonths(6),
            'notes' => 'Active community member',
            'is_active' => true,
        ]);

        // Create Family Members
        FamilyMember::create([
            'family_id' => $family1->id,
            'name' => 'Ahmed Hassan',
            'relation' => 'Head',
            'date_of_birth' => '1985-05-15',
            'gender' => 'Male',
            'occupation' => 'Engineer',
            'education' => 'Bachelor of Engineering',
            'phone' => '077-1234567',
            'email' => 'ahmed.hassan@example.com',
            'blood_group' => 'O+',
        ]);

        FamilyMember::create([
            'family_id' => $family1->id,
            'name' => 'Fatima Hassan',
            'relation' => 'Wife',
            'date_of_birth' => '1988-08-20',
            'gender' => 'Female',
            'occupation' => 'Teacher',
            'education' => 'Bachelor of Education',
            'blood_group' => 'A+',
        ]);

        $family2 = Family::create([
            'mosque_id' => $mosque->id,
            'family_head_name' => 'Ibrahim Ali',
            'phone' => '077-7654321',
            'email' => 'ibrahim.ali@example.com',
            'address' => '78 Park Avenue',
            'city' => 'Colombo',
            'state' => 'Western Province',
            'postal_code' => '00300',
            'total_members' => 3,
            'registration_date' => now()->subMonths(3),
            'is_active' => true,
        ]);

        // Create Sample Donations
        Donation::create([
            'mosque_id' => $mosque->id,
            'family_id' => $family1->id,
            'donor_name' => 'Ahmed Hassan',
            'donor_phone' => '077-1234567',
            'donor_email' => 'ahmed.hassan@example.com',
            'amount' => 5000.00,
            'donation_type' => 'Zakat',
            'payment_method' => 'Bank Transfer',
            'receipt_number' => 'DON-2025-001',
            'donation_date' => now()->subDays(10),
            'purpose' => 'Annual Zakat contribution',
            'is_anonymous' => false,
        ]);

        Donation::create([
            'mosque_id' => $mosque->id,
            'family_id' => $family2->id,
            'donor_name' => 'Ibrahim Ali',
            'donor_phone' => '077-7654321',
            'amount' => 2500.00,
            'donation_type' => 'General',
            'payment_method' => 'Cash',
            'receipt_number' => 'DON-2025-002',
            'donation_date' => now()->subDays(5),
            'purpose' => 'Mosque maintenance',
            'is_anonymous' => false,
        ]);

        // Create Sample Santhas (Prayer Times)
        $currentMonth = now()->format('F Y');
        $lastMonth = now()->subMonth()->format('F Y');

        // Current month payments
        Santha::create([
            'mosque_id' => $mosque->id,
            'family_id' => $family1->id,
            'amount' => 500.00,
            'month' => $currentMonth,
            'year' => now()->year,
            'payment_date' => now()->startOfMonth(),
            'payment_method' => 'Cash',
            'receipt_number' => 'SAN-' . now()->format('Ym') . '-001',
            'is_paid' => true,
            'notes' => 'Monthly membership payment',
        ]);

        Santha::create([
            'mosque_id' => $mosque->id,
            'family_id' => $family2->id,
            'amount' => 500.00,
            'month' => $currentMonth,
            'year' => now()->year,
            'payment_date' => now()->startOfMonth()->addDays(5),
            'payment_method' => 'Bank Transfer',
            'receipt_number' => 'SAN-' . now()->format('Ym') . '-002',
            'is_paid' => true,
        ]);

        // Last month payments
        Santha::create([
            'mosque_id' => $mosque->id,
            'family_id' => $family1->id,
            'amount' => 500.00,
            'month' => $lastMonth,
            'year' => now()->subMonth()->year,
            'payment_date' => now()->subMonth()->startOfMonth(),
            'payment_method' => 'Cash',
            'receipt_number' => 'SAN-' . now()->subMonth()->format('Ym') . '-001',
            'is_paid' => true,
        ]);
    }
}

