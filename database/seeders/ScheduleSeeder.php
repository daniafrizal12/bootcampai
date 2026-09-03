<?php

namespace Database\Seeders;

use App\Enums\ScheduleStatus;
use App\Enums\ScheduleType;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctors = Doctor::where('is_active', true)->get();

        $shifts = [
            ['start' => '08:00', 'end' => '12:00', 'notes' => 'Sesi Pagi'],
            ['start' => '13:00', 'end' => '16:30', 'notes' => 'Sesi Siang'],
            ['start' => '17:00', 'end' => '20:30', 'notes' => 'Sesi Sore/Malam'],
        ];

        foreach ($doctors as $index => $doctor) {
            // Assign 3-4 days of practice for each doctor
            // 1=Senin, 2=Selasa, 3=Rabu, 4=Kamis, 5=Jumat, 6=Sabtu
            $practiceDays = match ($index % 3) {
                0 => [1, 3, 5], // Senin, Rabu, Jumat
                1 => [2, 4, 6], // Selasa, Kamis, Sabtu
                2 => [1, 2, 4, 5], // Senin, Selasa, Kamis, Jumat
            };

            $shift = $shifts[$index % count($shifts)];

            foreach ($practiceDays as $day) {
                Schedule::updateOrCreate(
                    [
                        'doctor_id' => $doctor->id,
                        'day_of_week' => $day,
                        'type' => ScheduleType::Recurring,
                        'start_time' => $shift['start'],
                    ],
                    [
                        'end_time' => $shift['end'],
                        'max_patients' => 20,
                        'status' => ScheduleStatus::Active,
                        'notes' => "Jadwal Praktik {$shift['notes']} - {$doctor->specialty}",
                    ]
                );
            }
        }
    }
}
