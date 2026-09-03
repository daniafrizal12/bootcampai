<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Klinik',
            'email' => 'admin@klinik.test',
        ]);

        $this->call([
            DoctorSeeder::class,
            PatientSeeder::class,
            ServiceCounterSeeder::class,
            ScheduleSeeder::class,
            AppointmentSeeder::class,
            QueueTicketSeeder::class,
        ]);
    }
}
