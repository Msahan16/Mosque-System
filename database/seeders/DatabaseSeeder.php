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

        // Create Multiple Sample Families
        $familiesData = [
            [
                'family_head_name' => 'Ahmed Hassan',
                'family_head_profession' => 'Engineer',
                'phone' => '077-1234567',
                'email' => 'ahmed.hassan@example.com',
                'address' => '45 Main Street, Colombo',
                'total_members' => 4,
                'family_income' => 150000.00,
            ],
            [
                'family_head_name' => 'Ibrahim Ali',
                'family_head_profession' => 'Doctor',
                'phone' => '077-7654321',
                'email' => 'ibrahim.ali@example.com',
                'address' => '78 Park Avenue, Colombo',
                'total_members' => 3,
                'family_income' => 200000.00,
            ],
            [
                'family_head_name' => 'Mohammad Rashid',
                'family_head_profession' => 'Business Owner',
                'phone' => '077-5555555',
                'email' => 'rashid@example.com',
                'address' => '12 Market Lane, Colombo',
                'total_members' => 5,
                'family_income' => 180000.00,
            ],
            [
                'family_head_name' => 'Hassan Khan',
                'family_head_profession' => 'Teacher',
                'phone' => '077-4444444',
                'email' => 'hassan@example.com',
                'address' => '34 School Road, Colombo',
                'total_members' => 3,
                'family_income' => 80000.00,
            ],
            [
                'family_head_name' => 'Abdullah Mohamed',
                'family_head_profession' => 'Accountant',
                'phone' => '077-3333333',
                'email' => 'abdullah@example.com',
                'address' => '56 Finance Street, Colombo',
                'total_members' => 2,
                'family_income' => 120000.00,
            ],
        ];

        $families = [];
        foreach ($familiesData as $data) {
            $families[] = Family::create([
                'mosque_id' => $mosque->id,
                'family_head_name' => $data['family_head_name'],
                'family_head_profession' => $data['family_head_profession'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'address' => $data['address'],
                'total_members' => $data['total_members'],
                'registration_date' => now()->subMonths(rand(1, 12)),
                'notes' => '',
                'is_active' => true,
                'family_income' => $data['family_income'],
            ]);
        }

        // Create Family Members for first family
        FamilyMember::create([
            'family_id' => $families[0]->id,
            'name' => 'Ahmed Hassan',
            'relation' => 'Head',
            'date_of_birth' => '1985-05-15',
            'gender' => 'Male',
            'occupation' => 'Engineer',
            'phone' => '077-1234567',
        ]);

        FamilyMember::create([
            'family_id' => $families[0]->id,
            'name' => 'Fatima Hassan',
            'relation' => 'Wife',
            'date_of_birth' => '1988-08-20',
            'gender' => 'Female',
            'occupation' => 'Teacher',
        ]);

        // Create Multiple Donations
        $donationsData = [
            ['donor_name' => 'Ahmed Hassan', 'amount' => 5000, 'type' => 'Zakat', 'family_id' => $families[0]->id, 'days_ago' => 10],
            ['donor_name' => 'Ibrahim Ali', 'amount' => 2500, 'type' => 'General', 'family_id' => $families[1]->id, 'days_ago' => 5],
            ['donor_name' => 'Mohammad Rashid', 'amount' => 8000, 'type' => 'Sadaqah', 'family_id' => $families[2]->id, 'days_ago' => 3],
            ['donor_name' => 'Hassan Khan', 'amount' => 1500, 'type' => 'General', 'family_id' => $families[3]->id, 'days_ago' => 7],
            ['donor_name' => 'Abdullah Mohamed', 'amount' => 3000, 'type' => 'Zakat', 'family_id' => $families[4]->id, 'days_ago' => 2],
        ];

        foreach ($donationsData as $index => $data) {
            Donation::create([
                'mosque_id' => $mosque->id,
                'family_id' => $data['family_id'],
                'donor_name' => $data['donor_name'],
                'donor_phone' => '077-' . str_pad($index, 7, '0', STR_PAD_LEFT),
                'donor_email' => strtolower(str_replace(' ', '.', $data['donor_name'])) . '@example.com',
                'amount' => $data['amount'],
                'donation_type' => $data['type'],
                'payment_method' => rand(0, 1) ? 'Bank Transfer' : 'Cash',
                'receipt_number' => 'DON-' . now()->format('Ymd') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'donation_date' => now()->subDays($data['days_ago']),
                'purpose' => 'Monthly contribution',
                'is_anonymous' => false,
            ]);
        }

        // Create Santhas (Monthly Payments) - Multiple months
        $monthsToCreate = 3;
        for ($m = 0; $m < $monthsToCreate; $m++) {
            $monthDate = now()->subMonths($m);
            $monthName = $monthDate->format('F Y');
            
            foreach ($families as $index => $family) {
                Santha::create([
                    'mosque_id' => $mosque->id,
                    'family_id' => $family->id,
                    'amount' => 500.00,
                    'month' => $monthName,
                    'year' => $monthDate->year,
                    'payment_date' => $monthDate->startOfMonth()->addDays(rand(0, 5)),
                    'payment_method' => rand(0, 1) ? 'Cash' : 'Bank Transfer',
                    'receipt_number' => 'SAN-' . $monthDate->format('Ymd') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                    'is_paid' => true,
                    'status' => 'paid',
                    'notes' => 'Monthly membership payment',
                ]);
            }
        }

        // Create Imams
        $imamsData = [
            ['name' => 'Sheikh Abdullah', 'phone' => '077-1111111', 'email' => 'sheikh.abdullah@example.com'],
            ['name' => 'Sheikh Muhammad', 'phone' => '077-2222222', 'email' => 'sheikh.muhammad@example.com'],
            ['name' => 'Sheikh Ali', 'phone' => '077-3333333', 'email' => 'sheikh.ali@example.com'],
        ];

        $imams = [];
        foreach ($imamsData as $data) {
            $imams[] = Imam::create([
                'mosque_id' => $mosque->id,
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'qualification' => 'Islamic Scholar',
                'experience' => 'Experienced in Islamic teachings',
                'monthly_salary' => 50000.00,
                'status' => 'active',
            ]);
        }

        // Create Imam Financial Records
        foreach ($imams as $imam) {
            for ($m = 0; $m < 3; $m++) {
                ImamFinancialRecord::create([
                    'imam_id' => $imam->id,
                    'mosque_id' => $mosque->id,
                    'type' => 'salary',
                    'amount' => 50000.00,
                    'record_date' => now()->subMonths($m)->startOfMonth(),
                    'payment_date' => now()->subMonths($m)->startOfMonth(),
                    'payment_method' => 'Bank Transfer',
                    'status' => 'paid',
                    'basic_salary' => 50000.00,
                ]);
            }
        }

        // Create Ustads (Islamic Teachers)
        $ustadsData = [
            ['name' => 'Ustad Hassan', 'phone' => '077-8888888', 'email' => 'ustad.hassan@example.com'],
            ['name' => 'Ustad Omar', 'phone' => '077-9999999', 'email' => 'ustad.omar@example.com'],
            ['name' => 'Ustad Fatima', 'phone' => '077-6666666', 'email' => 'ustad.fatima@example.com'],
        ];

        $ustads = [];
        foreach ($ustadsData as $data) {
            $ustads[] = Ustad::create([
                'mosque_id' => $mosque->id,
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'qualification' => 'Hafiz/Hafiza',
                'experience_years' => rand(2, 15),
                'is_active' => true,
                'joining_date' => now()->subMonths(rand(6, 24)),
            ]);
        }

        // Create Students
        $students = [];
        foreach ($families as $family) {
            for ($s = 0; $s < rand(1, 3); $s++) {
                $students[] = Student::create([
                    'mosque_id' => $mosque->id,
                    'ustad_id' => $ustads[array_rand($ustads)]->id,
                    'name' => $family->family_head_name . ' - Student ' . ($s + 1),
                    'parent_name' => $family->family_head_name,
                    'parent_phone' => $family->phone,
                    'address' => $family->address,
                    'date_of_birth' => now()->subYears(rand(5, 15)),
                    'gender' => rand(0, 1) ? 'Male' : 'Female',
                    'class_level' => ['Beginner', 'Intermediate', 'Advanced'][rand(0, 2)],
                    'enrollment_date' => now()->subMonths(rand(1, 24)),
                    'is_active' => true,
                ]);
            }
        }

        // Create Student Payments
        foreach ($students as $student) {
            for ($p = 0; $p < 3; $p++) {
                $month = now()->subMonths($p)->month;
                StudentPayment::create([
                    'student_id' => $student->id,
                    'mosque_id' => $mosque->id,
                    'amount' => 2000.00,
                    'payment_date' => now()->subMonths($p)->startOfMonth(),
                    'payment_method' => rand(0, 1) ? 'Cash' : 'Bank Transfer',
                    'payment_type' => 'Monthly Fee',
                    'payment_months' => json_encode([$month]),
                    'payment_year' => now()->subMonths($p)->year,
                ]);
            }
        }

        // Create Porridge Sponsors
        $ramdanYear = now()->year;
        foreach ($families as $index => $family) {
            if (rand(0, 1)) {
                PorridgeSponsor::create([
                    'mosque_id' => $mosque->id,
                    'ramadan_year' => $ramdanYear,
                    'day_number' => (($index + 1) * 3) % 30 ?: 1,
                    'sponsor_name' => $family->family_head_name,
                    'sponsor_phone' => $family->phone,
                    'sponsor_type' => 'individual',
                    'porridge_count' => rand(20, 100),
                    'amount_per_porridge' => 500.00,
                    'total_amount' => rand(20, 100) * 500,
                    'payment_status' => 'paid',
                    'distribution_status' => 'distributed',
                    'payment_method' => rand(0, 1) ? 'cash' : 'bank_transfer',
                    'created_by' => $admin->id,
                ]);
            }
        }
    }
}
