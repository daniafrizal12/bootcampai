<?php

namespace Database\Seeders;

use App\Enums\AppointmentStatus;
use App\Enums\QueuePriority;
use App\Enums\QueueStatus;
use App\Models\Appointment;
use App\Models\QueueTicket;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QueueTicketSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today()->format('Y-m-d');

        // Fetch today's appointments that have been checked-in or in progress
        $appointments = Appointment::where('appointment_date', $today)
            ->whereIn('status', [
                AppointmentStatus::CheckedIn,
                AppointmentStatus::InProgress,
                AppointmentStatus::Completed,
            ])
            ->with(['doctor', 'schedule'])
            ->orderBy('created_at')
            ->get();

        $doctorCounters = [];
        $doctorPrefixes = [
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
            5 => 'E',
            6 => 'F',
        ];

        foreach ($appointments as $appointment) {
            $doctorId = $appointment->doctor_id;
            $doctorCounters[$doctorId] = ($doctorCounters[$doctorId] ?? 0) + 1;
            $queueNumber = $doctorCounters[$doctorId];
            $prefix = $doctorPrefixes[$doctorId] ?? 'A';
            $displayNumber = QueueTicket::formatDisplayNumber($prefix, $queueNumber);

            $queueStatus = match ($appointment->status) {
                AppointmentStatus::InProgress => QueueStatus::Serving,
                AppointmentStatus::Completed => QueueStatus::Completed,
                default => QueueStatus::Waiting,
            };

            $calledAt = in_array($queueStatus, [QueueStatus::Serving, QueueStatus::Completed]) ? now()->subMinutes(15) : null;
            $servedAt = in_array($queueStatus, [QueueStatus::Serving, QueueStatus::Completed]) ? now()->subMinutes(12) : null;
            $completedAt = $queueStatus === QueueStatus::Completed ? now()->subMinutes(2) : null;

            QueueTicket::updateOrCreate(
                ['appointment_id' => $appointment->id],
                [
                    'doctor_id' => $appointment->doctor_id,
                    'schedule_id' => $appointment->schedule_id,
                    'queue_date' => $today,
                    'queue_number' => $queueNumber,
                    'prefix' => $prefix,
                    'display_number' => $displayNumber,
                    'status' => $queueStatus,
                    'priority' => fake()->randomElement([QueuePriority::Normal, QueuePriority::Normal, QueuePriority::Priority]),
                    'counter' => 'Poli ' . ($appointment->doctor->specialty ?? 'Umum'),
                    'call_count' => in_array($queueStatus, [QueueStatus::Serving, QueueStatus::Completed]) ? 1 : 0,
                    'called_at' => $calledAt,
                    'served_at' => $servedAt,
                    'completed_at' => $completedAt,
                ]
            );
        }
    }
}
