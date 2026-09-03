<?php

namespace App\Models;

use App\Enums\QueuePriority;
use App\Enums\QueueStatus;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QueueTicket extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'queue_tickets';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'appointment_id',
        'doctor_id',
        'schedule_id',
        'queue_date',
        'queue_number',
        'prefix',
        'display_number',
        'status',
        'priority',
        'counter',
        'call_count',
        'called_at',
        'served_at',
        'completed_at',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'queue_date' => 'date',
            'queue_number' => 'integer',
            'call_count' => 'integer',
            'called_at' => 'datetime',
            'served_at' => 'datetime',
            'completed_at' => 'datetime',
            'status' => QueueStatus::class,
            'priority' => QueuePriority::class,
        ];
    }

    /**
     * Get the appointment associated with the queue ticket.
     */
    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get the doctor associated with the queue ticket.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the schedule associated with the queue ticket.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get formatted display number.
     */
    public static function formatDisplayNumber(string $prefix, int $number): string
    {
        return sprintf('%s-%03d', strtoupper($prefix), $number);
    }
}
