<?php

namespace Database\Factories;

use App\Enums\QueuePriority;
use App\Enums\QueueStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\QueueTicket;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<QueueTicket>
 */
class QueueTicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<QueueTicket>
     */
    protected $model = QueueTicket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $queueNumber = fake()->numberBetween(1, 50);
        $prefix = fake()->randomElement(['A', 'B', 'C', 'D']);

        return [
            'appointment_id' => Appointment::factory(),
            'doctor_id' => Doctor::factory(),
            'schedule_id' => Schedule::factory(),
            'queue_date' => now()->format('Y-m-d'),
            'queue_number' => $queueNumber,
            'prefix' => $prefix,
            'display_number' => QueueTicket::formatDisplayNumber($prefix, $queueNumber),
            'status' => QueueStatus::Waiting,
            'priority' => QueuePriority::Normal,
            'counter' => 'Poli ' . $prefix,
            'call_count' => 0,
            'called_at' => null,
            'served_at' => null,
            'completed_at' => null,
            'notes' => null,
        ];
    }

    /**
     * State for waiting in queue.
     */
    public function waiting(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QueueStatus::Waiting,
            'call_count' => 0,
        ]);
    }

    /**
     * State for currently serving ticket.
     */
    public function serving(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QueueStatus::Serving,
            'call_count' => 1,
            'called_at' => now()->subMinutes(10),
            'served_at' => now()->subMinutes(8),
        ]);
    }

    /**
     * State for completed ticket.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QueueStatus::Completed,
            'call_count' => 1,
            'called_at' => now()->subMinutes(40),
            'served_at' => now()->subMinutes(38),
            'completed_at' => now()->subMinutes(15),
        ]);
    }

    /**
     * State for skipped ticket.
     */
    public function skipped(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => QueueStatus::Skipped,
            'call_count' => 3,
            'called_at' => now()->subMinutes(25),
        ]);
    }

    /**
     * Set ticket priority.
     */
    public function priority(QueuePriority $priority = QueuePriority::Priority): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => $priority,
        ]);
    }
}
