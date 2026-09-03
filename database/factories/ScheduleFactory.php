<?php

namespace Database\Factories;

use App\Enums\ScheduleStatus;
use App\Enums\ScheduleType;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<Schedule>
     */
    protected $model = Schedule::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $shifts = [
            ['start' => '08:00', 'end' => '12:00'],
            ['start' => '13:00', 'end' => '16:00'],
            ['start' => '16:30', 'end' => '20:30'],
        ];

        $shift = fake()->randomElement($shifts);

        return [
            'doctor_id' => Doctor::factory(),
            'day_of_week' => fake()->numberBetween(1, 6), // Senin - Sabtu
            'specific_date' => null,
            'start_time' => $shift['start'],
            'end_time' => $shift['end'],
            'max_patients' => fake()->numberBetween(15, 30),
            'status' => ScheduleStatus::Active,
            'type' => ScheduleType::Recurring,
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Schedule for morning shift.
     */
    public function morning(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => '08:00',
            'end_time' => '12:00',
        ]);
    }

    /**
     * Schedule for afternoon shift.
     */
    public function afternoon(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => '13:00',
            'end_time' => '16:30',
        ]);
    }

    /**
     * Schedule for evening shift.
     */
    public function evening(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_time' => '17:00',
            'end_time' => '21:00',
        ]);
    }

    /**
     * One-time schedule for a specific date.
     */
    public function oneTime(\DateTimeInterface|string $date): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => ScheduleType::OneTime,
            'specific_date' => $date,
            'day_of_week' => null,
        ]);
    }

    /**
     * Inactive schedule.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => ScheduleStatus::Inactive,
        ]);
    }
}
