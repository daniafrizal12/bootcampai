<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DoctorSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultDoctors = [
            [
                'name' => 'dr. Budi Santoso, Sp.PD',
                'license_number' => 'STR-3171012345000001',
                'email' => 'budi.santoso@klinik.test',
                'password' => Hash::make('password'),
                'phone' => '081234567801',
                'specialty' => 'Spesialis Penyakit Dalam (Sp.PD)',
                'bio' => 'Dokter spesialis penyakit dalam dengan pengalaman lebih dari 10 tahun dalam penanganan diabetes, hipertensi, dan penyakit metabolik.',
                'is_active' => true,
            ],
            [
                'name' => 'dr. Siti Rahmawati, Sp.A',
                'license_number' => 'STR-3171012345000002',
                'email' => 'siti.rahmawati@klinik.test',
                'password' => Hash::make('password'),
                'phone' => '081234567802',
                'specialty' => 'Spesialis Anak (Sp.A)',
                'bio' => 'Spesialis kesehatan anak dan tumbuh kembang balita dengan pendekatan ramah anak.',
                'is_active' => true,
            ],
            [
                'name' => 'dr. Andi Wijaya',
                'license_number' => 'STR-3171012345000003',
                'email' => 'andi.wijaya@klinik.test',
                'password' => Hash::make('password'),
                'phone' => '081234567803',
                'specialty' => 'Dokter Umum',
                'bio' => 'Dokter umum berdedikasi melayani pemeriksaan kesehatan menyeluruh, konsultasi awal, dan vaksinasi.',
                'is_active' => true,
            ],
            [
                'name' => 'dr. Maya Indah, Sp.OG',
                'license_number' => 'STR-3171012345000004',
                'email' => 'maya.indah@klinik.test',
                'password' => Hash::make('password'),
                'phone' => '081234567804',
                'specialty' => 'Spesialis Kandungan & Kebidanan (Sp.OG)',
                'bio' => 'Melayani pemeriksaan kehamilan (USG 4D), program hamil, serta kesehatan reproduksi wanita.',
                'is_active' => true,
            ],
            [
                'name' => 'dr. Hendra Pratama, Sp.M',
                'license_number' => 'STR-3171012345000005',
                'email' => 'hendra.pratama@klinik.test',
                'password' => Hash::make('password'),
                'phone' => '081234567805',
                'specialty' => 'Spesialis Mata (Sp.M)',
                'bio' => 'Spesialis pemeriksaan refraksi mata, katarak, glaukoma, dan gangguan penglihatan lainnya.',
                'is_active' => true,
            ],
            [
                'name' => 'drg. Ratna Dewi, Sp.Ort',
                'license_number' => 'STR-3171012345000006',
                'email' => 'ratna.dewi@klinik.test',
                'password' => Hash::make('password'),
                'phone' => '081234567806',
                'specialty' => 'Spesialis Gigi & Mulut (Sp.Ort)',
                'bio' => 'Spesialis perawatan ortodonti (kawat gigi), estetika gigi, dan penambalan gigi.',
                'is_active' => true,
            ],
        ];

        foreach ($defaultDoctors as $doctorData) {
            Doctor::updateOrCreate(
                ['email' => $doctorData['email']],
                $doctorData
            );
        }

        // Generate 6 additional doctors using factory
        Doctor::factory()
            ->count(6)
            ->create();
    }
}
