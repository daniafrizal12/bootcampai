<?php

namespace Database\Seeders;

use App\Models\ServiceCounter;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceCounterSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counters = [
            [
                'name' => 'Loket Pendaftaran & Check-In 1',
                'code' => 'LOKET-01',
                'location' => 'Lantai 1 - Lobi Utama',
                'is_active' => true,
            ],
            [
                'name' => 'Loket Pendaftaran & Check-In 2',
                'code' => 'LOKET-02',
                'location' => 'Lantai 1 - Lobi Utama',
                'is_active' => true,
            ],
            [
                'name' => 'Poli Umum',
                'code' => 'POLI-UMUM',
                'location' => 'Lantai 1 - Ruang 101',
                'is_active' => true,
            ],
            [
                'name' => 'Poli Penyakit Dalam',
                'code' => 'POLI-INTERNA',
                'location' => 'Lantai 1 - Ruang 102',
                'is_active' => true,
            ],
            [
                'name' => 'Poli Anak',
                'code' => 'POLI-ANAK',
                'location' => 'Lantai 1 - Ruang 103',
                'is_active' => true,
            ],
            [
                'name' => 'Poli Kandungan & Kebidanan',
                'code' => 'POLI-OBGYN',
                'location' => 'Lantai 2 - Ruang 201',
                'is_active' => true,
            ],
            [
                'name' => 'Poli Gigi & Mulut',
                'code' => 'POLI-GIGI',
                'location' => 'Lantai 2 - Ruang 202',
                'is_active' => true,
            ],
            [
                'name' => 'Poli Mata',
                'code' => 'POLI-MATA',
                'location' => 'Lantai 2 - Ruang 203',
                'is_active' => true,
            ],
        ];

        foreach ($counters as $counter) {
            ServiceCounter::updateOrCreate(
                ['code' => $counter['code']],
                $counter
            );
        }
    }
}
