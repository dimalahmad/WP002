<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Vendor;
use App\Models\Employee;
use App\Models\WorkPermit;
use App\Models\Violation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Reset Database (Optional, but good for clean slate)
        // DB::statement('DELETE FROM users');
        // DB::statement('DELETE FROM vendors');
        // DB::statement('DELETE FROM employees');
        // DB::statement('DELETE FROM work_permits');
        // DB::statement('DELETE FROM violations');

        // --------------------------------------------------------------------------------
        // 1. CREATE VENDORS (30 Vendors)
        // --------------------------------------------------------------------------------
        $vendorNames = [
            'PT. Teknologi Maju',
            'PT. Konstruksi Baja Sejahtera',
            'CV. Sumber Masalah',
            'PT. Cilegon Engineering',
            'CV. Baratech Service',
            'PT. Global Supply Chain',
            'PT. Sarana Konstruksi Utama',
            'CV. Teknik Mandiri',
            'PT. Delta Safety Solution',
            'CV. Berkah Cahaya',
            'PT. Inti Karya Semesta',
            'PT. Pilar Beton Perkasa',
            'CV. Elektronika Dasar',
            'PT. Mega Trans Logistik',
            'CV. Sumber Makmur',
            'PT. Buana Citra Konsultan',
            'CV. Mitra Sejahtera',
            'PT. Harapan Bangsa',
            'CV. Karya Duta',
            'PT. Universal Trading',
            'PT. Galangan Samudera',
            'CV. Arta Graha',
            'PT. Sentosa Abadi',
            'CV. Bintang Mas',
            'PT. Anugerah Teknik',
            'CV. Multi Sarana',
            'PT. Prima Daya Energy',
            'CV. Tunas Harapan',
            'PT. Wira Sakti',
            'CV. Kencana Alam'
        ];

        $vendors = [];
        foreach ($vendorNames as $index => $name) {
            $isBlacklisted = ($index === 2) || (rand(0, 20) == 0); // CV. Sumber Masalah & random others
            $vendors[] = Vendor::create([
                'name' => $name,
                'address' => 'Jl. Industri Kawasan KIEC Blok ' . chr(65 + $index),
                'pic_name' => 'PIC ' . explode(' ', $name)[1],
                'phone_number' => '08' . rand(10, 19) . rand(10000000, 99999999),
                'notes' => $isBlacklisted ? 'Blacklisted karena kinerja buruk' : 'Vendor Terverifikasi',
                'status' => $isBlacklisted ? 'blacklisted' : 'active'
            ]);
        }

        $allVendors = Vendor::all();

        // --------------------------------------------------------------------------------
        // 2. CREATE USERS
        // --------------------------------------------------------------------------------

        // Admin HSE
        User::create([
            'name' => 'Admin HSE',
            'email' => 'hse@krakatau.com',
            'password' => Hash::make('password'),
            'role' => 'hse',
        ]);

        // Corsec
        User::create([
            'name' => 'Siti Corsec',
            'email' => 'corsec@krakatau.com',
            'password' => Hash::make('password'),
            'role' => 'corsec',
        ]);

        // Vendor User (Simulasi Login untuk Vendor ID 1 - PT. Teknologi Maju)
        User::create([
            'name' => 'User Vendor 1',
            'email' => 'vendor1@krakatau.com',
            'password' => Hash::make('password'),
            'role' => 'vendor_user',
            'vendor_id' => $allVendors[0]->id
        ]);

        // Vendor User 2
        User::create([
            'name' => 'User Vendor 2',
            'email' => 'vendor2@krakatau.com',
            'password' => Hash::make('password'),
            'role' => 'vendor_user',
            'vendor_id' => $allVendors[1]->id
        ]);

        // --------------------------------------------------------------------------------
        // 3. CREATE EMPLOYEES (150 Employees)
        // --------------------------------------------------------------------------------
        $firstNames = ['Agus', 'Budi', 'Citra', 'Dedi', 'Eka', 'Fajar', 'Gita', 'Hendra', 'Indah', 'Joko', 'Kartika', 'Lukman', 'Maya', 'Nanda', 'Olivia', 'Prasetyo', 'Qori', 'Rahmat', 'Siti', 'Taufik'];
        $lastNames = ['Santoso', 'Wijaya', 'Kurniawan', 'Putri', 'Nugroho', 'Permata', 'Sari', 'Susilo', 'Dewi', 'Hakim', 'Anggraini', 'Pratama', 'Gunawan', 'Wibowo', 'Aulia', 'Hidayat', 'Aminah', 'Rahman', 'Wulandari', 'Melati'];

        $allEmployees = [];
        $blacklistedEmployees = [];

        foreach ($allVendors as $vendor) {
            // Create 3-8 employees per vendor
            $count = rand(3, 8);
            for ($i = 0; $i < $count; $i++) {
                $fName = $firstNames[array_rand($firstNames)];
                $lName = $lastNames[array_rand($lastNames)];
                $fullName = $fName . ' ' . $lName;

                // Random Blacklist (5% chance)
                $isBlacklisted = (rand(1, 100) <= 5);

                $emp = Employee::create([
                    'vendor_id' => $vendor->id,
                    'name' => $fullName,
                    'nik' => '3674' . rand(1000, 9999) . rand(1000, 9999),
                    'gender' => rand(0, 1) ? 'Laki-laki' : 'Perempuan',
                    'date_of_birth' => Carbon::createFromDate(rand(1980, 2000), rand(1, 12), rand(1, 28)),
                    'blood_type' => ['A', 'B', 'AB', 'O'][rand(0, 3)],
                    'address' => 'Komplek Perumahan ' . chr(rand(65, 90)) . ' No. ' . rand(1, 100),
                    'is_blacklisted' => $isBlacklisted
                ]);
                $allEmployees[] = $emp;

                if ($isBlacklisted) {
                    $blacklistedEmployees[] = $emp;
                    // Create Violation Record
                    Violation::create([
                        'violator_type' => Employee::class,
                        'violator_id' => $emp->id,
                        'violation_date' => Carbon::now()->subMonths(rand(1, 6)),
                        'severity' => 'Berat',
                        'description' => 'Melanggar prokes K3 dan merokok di area terlarang.',
                        'sanction' => 'Blacklist Permanen',
                        'status' => 'active'
                    ]);
                }
            }
        }

        // --------------------------------------------------------------------------------
        // 4. CREATE WORK PERMITS (50 WPs)
        // --------------------------------------------------------------------------------
        $workTypes = ['Pekerjaan Panas (Hot Work)', 'Pekerjaan di Ketinggian', 'Pekerjaan Listrik', 'Pekerjaan Ruang Terbatas (Confined Space)', 'Pekerjaan Pengalian (Excavation)'];
        $locations = ['Area Pabrik A', 'Area Pabrik B', 'Gedung Kantor Pusat', 'Warehouse Logistik', 'Dermaga Utility', 'Power Plant Area'];
        $statuses = ['draft', 'waiting_corsec', 'waiting_hse', 'scheduled', 'active', 'finished', 'rejected', 'expired'];

        for ($i = 1; $i <= 50; $i++) {
            $vendor = $allVendors[array_rand($allVendors->toArray())];
            // Skip blacklisted vendors for active WPs mostly, but let some be rejected

            $status = $statuses[array_rand($statuses)];
            $startDate = Carbon::today()->subDays(rand(-10, 30)); // -10 days ago to +30 days future
            $endDate = (clone $startDate)->addDays(rand(3, 14));

            // Logic status adjustments
            if ($status == 'active') {
                $startDate = Carbon::yesterday();
                $endDate = Carbon::tomorrow()->addDays(5);
            } elseif ($status == 'expired') {
                $startDate = Carbon::today()->subMonth();
                $endDate = Carbon::today()->subWeeks(2);
            }

            $wp = WorkPermit::create([
                'doc_no' => 'WP-2026-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'vendor_id' => $vendor->id,
                'work_type' => $workTypes[array_rand($workTypes)],
                'work_description' => 'Melakukan perbaikan dan maintenance rutin pada equipment ' . rand(100, 999),
                'location' => $locations[array_rand($locations)],
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => $status,
                'induction_schedule' => ($status == 'scheduled' || $status == 'active' || $status == 'finished') ? $startDate->subDay()->setHour(9) : null,
                'induction_evidence_path' => ($status == 'active' || $status == 'finished') ? 'evidence_dummy.pdf' : null,
                'rejection_note' => ($status == 'rejected') ? 'Dokumen persyaratan tidak lengkap.' : null,
                'safety_checklist' => json_encode(['apd' => ['Safety Helmet', 'Safety Shoes'], 'pengaman' => ['APAR']])
            ]);

            // Attach 2-5 employees from this vendor
            $vendorEmployees = Employee::where('vendor_id', $vendor->id)->inRandomOrder()->take(rand(2, 5))->pluck('id');
            if ($vendorEmployees->count() > 0) {
                $wp->employees()->attach($vendorEmployees);
            }
        }
        // --------------------------------------------------------------------------------
        // 6. CREATE MASTER HSE DATA (APD, SAFETY, IKB)
        // --------------------------------------------------------------------------------

        $apds = ['Helmet', 'Safety Shoes', 'Sarung Tangan', 'Kaca Mata Safety', 'Masker', 'Pelindung Wajah', 'Body Harnest', 'Kedok Las', 'Air Line Respirator', 'Breathing Apparatus', 'Baju Tahan Panas'];
        foreach ($apds as $item) {
            \App\Models\SafetyEquipment::create(['name' => $item, 'type' => 'apd']);
        }

        $safeties = ['Isolasi Power Supply', 'Hydr. System Off', 'Bekas Gas Beracun', 'Tag Out', 'Log Out', 'APAR', 'Hydrant', 'Safety Line', 'Lampu Penerangan DC 50 Volt'];
        foreach ($safeties as $item) {
            \App\Models\SafetyEquipment::create(['name' => $item, 'type' => 'safety_device']);
        }

        // Contoh IKB
        \App\Models\RiskWork::create([
            'name' => 'Pekerjaan Pengelasan (Welding)',
            'recommended_apd' => ['All'],
            'recommended_safety' => ['APAR', 'Fire Blanket']
        ]);
    }
}
