<?php

namespace App\Models;

use App\Enums\ScheduleStatus;
use App\Enums\ScheduleType;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\QueueTicket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'schedules';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'specific_date',
        'start_time',
        'end_time',
        'max_patients',
        'status',
        'type',
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
            'day_of_week' => 'integer',
            'specific_date' => 'date',
            'max_patients' => 'integer',
            'status' => ScheduleStatus::class,
            'type' => ScheduleType::class,
        ];
    }

    /**
     * Get the doctor that owns the schedule.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the appointments for the schedule.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Get the queue tickets for the schedule.
     */
    public function queueTickets(): HasMany
    {
        return $this->hasMany(QueueTicket::class);
    }

    /**
     * Get Indonesian day name for day_of_week.
     */
    public function getDayNameAttribute(): ?string
    {
        if ($this->day_of_week === null) {
            return null;
        }

        $days = [
            0 => 'Minggu',
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            6 => 'Sabtu',
        ];

        return $days[$this->day_of_week] ?? null;
    }
}
