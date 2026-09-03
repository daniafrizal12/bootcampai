<?php

namespace Database\Seeders;

use App\Enums\BloodType;
use App\Enums\Gender;
use App\Models\Patient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PatientSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demoPatients = [
            [
                'medical_record_number' => 'RM-202609-0001',
                'name' => 'Bambang Sudarsono',
                'email' => 'bambang@pasien.test',
                'password' => Hash::make('password'),
                'date_of_birth' => '1985-06-15',
                'gender' => Gender::Male,
                'national_id' => '3171011506850001',
                'phone' => '081298765001',
                'address' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
                'blood_type' => BloodType::O,
                'allergies' => ['Amoxicillin', 'Aspirin'],
            ],
            [
                'name' => 'Siti Nurhaliza',
                'medical_record_number' => 'RM-202609-0002',
                'email' => 'ani@pasien.test',
                'password' => Hash::make('password'),
                'date_of_birth' => '1992-11-23',
                'gender' => Gender::Female,
                'national_id' => '3171012311920002',
                'phone' => '081298765002',
                'address' => 'Jl. Tebet Raya No. 45, Jakarta Selatan',
                'blood_type' => BloodType::A,
                'allergies' => null,
            ],
            [
                'name' => 'Citra Kirana',
                'medical_record_number' => 'RM-202609-0003',
                'email' => 'citra@pasien.test',
                'password' => Hash::make('password'),
                'date_of_birth' => '1998-04-09',
                'gender' => Gender::Female,
                'national_id' => '3171010904980003',
                'phone' => '081298765003',
                'address' => 'Jl. Cempaka Putih Tengah No. 8, Jakarta Pusat',
                'blood_type' => BloodType::B,
                'allergies' => ['Seafood'],
            ],
        ];

        foreach ($demoPatients as $patientData) {
            Patient::updateOrCreate(
                ['email' => $patientData['email']],
                $patientData
            );
        }

        // Generate 20 additional random patients
        Patient::factory()
            ->count(20)
            ->create();
    }
}
