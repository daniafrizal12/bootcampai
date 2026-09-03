<?php

namespace Database\Factories;

use App\Enums\AppointmentSource;
use App\Enums\AppointmentStatus;
use App\Enums\CheckInMethod;
use App\Enums\VisitType;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Appointment>
     */
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $complaints = [
            'Demam tinggi disertai sakit kepala sejak 3 hari yang lalu.',
            'Batuk kering dan sesak napas ringan.',
            'Pemeriksaan rutin tekanan darah dan kontrol kadar gula darah.',
            'Nyeri lambung / maag kambuh setelah makan pedas.',
            'Pemeriksaan kesehatan gigi dan pembersihan karang gigi.',
            'Konsultasi tumbuh kembang anak dan vaksinasi tahunan.',
            'Mata merah, berair, dan terasa perih.',
            'Pemeriksaan rutin USG kehamilan trimester 2.',
            'Nyeri sendi lutut ketika berjalan jauh.',
            'Gatal-gatal pada kulit tangan dan lengan.',
        ];

        return [
            'booking_code' => Appointment::generateBookingCode(),
            'patient_id' => Patient::factory(),
            'doctor_id' => Doctor::factory(),
            'schedule_id' => Schedule::factory(),
            'appointment_date' => fake()->dateTimeBetween('now', '+14 days')->format('Y-m-d'),
            'estimated_time' => fake()->randomElement(['08:30', '09:15', '10:00', '11:00', '13:30', '14:30', '17:30', '18:30']),
            'visit_type' => fake()->randomElement([VisitType::NewVisit, VisitType::FollowUp]),
            'chief_complaint' => fake()->randomElement($complaints),
            'patient_notes' => fake()->optional(0.4)->sentence(),
            'status' => AppointmentStatus::Confirmed,
            'source' => fake()->randomElement([AppointmentSource::Online, AppointmentSource::WalkIn, AppointmentSource::Phone]),
            'cancellation_reason' => null,
            'cancelled_at' => null,
            'checked_in_at' => null,
            'check_in_method' => null,
            'checked_in_by' => null,
            'created_by' => null,
            'metadata' => null,
        ];
    }

    /**
     * State for pending appointments.
     */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Pending,
        ]);
    }

    /**
     * State for confirmed appointments.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Confirmed,
        ]);
    }

    /**
     * State for checked-in appointments.
     */
    public function checkedIn(?CheckInMethod $method = CheckInMethod::Counter): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::CheckedIn,
            'checked_in_at' => now()->subMinutes(fake()->numberBetween(5, 45)),
            'check_in_method' => $method ?? CheckInMethod::Counter,
        ]);
    }

    /**
     * State for in-progress appointments.
     */
    public function inProgress(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::InProgress,
            'checked_in_at' => now()->subMinutes(fake()->numberBetween(30, 60)),
            'check_in_method' => CheckInMethod::Counter,
        ]);
    }

    /**
     * State for completed appointments.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Completed,
            'checked_in_at' => now()->subHours(2),
            'check_in_method' => CheckInMethod::Counter,
        ]);
    }

    /**
     * State for cancelled appointments.
     */
    public function cancelled(string $reason = 'Pasien berhalangan hadir'): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::Cancelled,
            'cancellation_reason' => $reason,
            'cancelled_at' => now()->subDay(),
        ]);
    }

    /**
     * State for no-show appointments.
     */
    public function noShow(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => AppointmentStatus::NoShow,
            'appointment_date' => now()->subDays(1)->format('Y-m-d'),
        ]);
    }
}
