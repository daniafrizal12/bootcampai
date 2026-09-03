<?php

namespace Database\Seeders;

use App\Enums\AppointmentSource;
use App\Enums\AppointmentStatus;
use App\Enums\CheckInMethod;
use App\Enums\VisitType;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = Patient::all();
        $doctors = Doctor::with('schedules')->where('is_active', true)->get();

        if ($patients->isEmpty() || $doctors->isEmpty()) {
            return;
        }

        $complaints = [
            'Demam tinggi dan sakit kepala sejak 3 hari.',
            'Pemeriksaan rutin gula darah dan tensi.',
            'Nyeri lambung / maag kambuh setelah makan pedas.',
            'Pembersihan karang gigi dan konsultasi gusi berdarah.',
            'Batuk berdahak dan pilek.',
            'Konsultasi tumbuh kembang balita.',
            'Mata perih dan berair saat melihat layar.',
            'Pemeriksaan USG kandungan rutin.',
            'Nyeri sendi pinggang dan lutut.',
        ];

        // 1. Seed past appointments (Last 7 days)
        for ($i = 7; $i >= 1; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayOfWeek = (int) $date->format('w');

            foreach ($doctors as $doctor) {
                $schedule = $doctor->schedules->firstWhere('day_of_week', $dayOfWeek);
                if (! $schedule) {
                    continue;
                }

                // Create 2-3 past completed appointments per active schedule
                $randomPatients = $patients->random(min(3, $patients->count()));
                foreach ($randomPatients as $patient) {
                    $status = fake()->randomElement([
                        AppointmentStatus::Completed,
                        AppointmentStatus::Completed,
                        AppointmentStatus::Completed,
                        AppointmentStatus::NoShow,
                        AppointmentStatus::Cancelled,
                    ]);

                    Appointment::create([
                        'booking_code' => Appointment::generateBookingCode(),
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'schedule_id' => $schedule->id,
                        'appointment_date' => $date->format('Y-m-d'),
                        'estimated_time' => $schedule->start_time,
                        'visit_type' => fake()->randomElement([VisitType::NewVisit, VisitType::FollowUp]),
                        'chief_complaint' => fake()->randomElement($complaints),
                        'status' => $status,
                        'source' => fake()->randomElement([AppointmentSource::Online, AppointmentSource::WalkIn]),
                        'checked_in_at' => in_array($status, [AppointmentStatus::Completed]) ? $date->copy()->setTimeFromTimeString($schedule->start_time)->subMinutes(15) : null,
                        'check_in_method' => in_array($status, [AppointmentStatus::Completed]) ? CheckInMethod::Counter : null,
                        'cancellation_reason' => $status === AppointmentStatus::Cancelled ? 'Pasien ada keperluan mendadak' : null,
                        'cancelled_at' => $status === AppointmentStatus::Cancelled ? $date->copy()->subDay() : null,
                    ]);
                }
            }
        }

        // 2. Seed today's appointments (Mix of Checked-in, In-progress, Confirmed, Pending)
        $today = Carbon::today();
        $todayDayOfWeek = (int) $today->format('w');

        foreach ($doctors as $doctor) {
            $schedule = $doctor->schedules->firstWhere('day_of_week', $todayDayOfWeek) ?? $doctor->schedules->first();
            if (! $schedule) {
                continue;
            }

            $todayPatients = $patients->random(min(4, $patients->count()));
            $statuses = [
                AppointmentStatus::InProgress,
                AppointmentStatus::CheckedIn,
                AppointmentStatus::Confirmed,
                AppointmentStatus::Pending,
            ];

            foreach ($todayPatients as $idx => $patient) {
                $status = $statuses[$idx % count($statuses)];
                $checkedInAt = in_array($status, [AppointmentStatus::CheckedIn, AppointmentStatus::InProgress])
                    ? now()->subMinutes(15 * ($idx + 1))
                    : null;

                Appointment::create([
                    'booking_code' => Appointment::generateBookingCode(),
                    'patient_id' => $patient->id,
                    'doctor_id' => $doctor->id,
                    'schedule_id' => $schedule->id,
                    'appointment_date' => $today->format('Y-m-d'),
                    'estimated_time' => $schedule->start_time,
                    'visit_type' => fake()->randomElement([VisitType::NewVisit, VisitType::FollowUp]),
                    'chief_complaint' => fake()->randomElement($complaints),
                    'status' => $status,
                    'source' => fake()->randomElement([AppointmentSource::Online, AppointmentSource::WalkIn]),
                    'checked_in_at' => $checkedInAt,
                    'check_in_method' => $checkedInAt ? CheckInMethod::SelfService : null,
                ]);
            }
        }

        // 3. Seed future appointments (Next 7 days)
        for ($i = 1; $i <= 7; $i++) {
            $futureDate = Carbon::today()->addDays($i);
            $dayOfWeek = (int) $futureDate->format('w');

            foreach ($doctors->take(4) as $doctor) {
                $schedule = $doctor->schedules->firstWhere('day_of_week', $dayOfWeek);
                if (! $schedule) {
                    continue;
                }

                $futurePatients = $patients->random(min(2, $patients->count()));
                foreach ($futurePatients as $patient) {
                    Appointment::create([
                        'booking_code' => Appointment::generateBookingCode(),
                        'patient_id' => $patient->id,
                        'doctor_id' => $doctor->id,
                        'schedule_id' => $schedule->id,
                        'appointment_date' => $futureDate->format('Y-m-d'),
                        'estimated_time' => $schedule->start_time,
                        'visit_type' => fake()->randomElement([VisitType::NewVisit, VisitType::FollowUp]),
                        'chief_complaint' => fake()->randomElement($complaints),
                        'status' => fake()->randomElement([AppointmentStatus::Confirmed, AppointmentStatus::Pending]),
                        'source' => AppointmentSource::Online,
                    ]);
                }
            }
        }
    }
}
