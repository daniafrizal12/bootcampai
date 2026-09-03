<?php

namespace App\Models;

use App\Enums\AppointmentSource;
use App\Enums\AppointmentStatus;
use App\Enums\CheckInMethod;
use App\Enums\VisitType;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\QueueTicket;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'appointments';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_code',
        'patient_id',
        'doctor_id',
        'schedule_id',
        'appointment_date',
        'estimated_time',
        'visit_type',
        'chief_complaint',
        'patient_notes',
        'status',
        'source',
        'cancellation_reason',
        'cancelled_at',
        'checked_in_at',
        'check_in_method',
        'checked_in_by',
        'created_by',
        'metadata',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'appointment_date' => 'date',
            'cancelled_at' => 'datetime',
            'checked_in_at' => 'datetime',
            'visit_type' => VisitType::class,
            'status' => AppointmentStatus::class,
            'source' => AppointmentSource::class,
            'check_in_method' => CheckInMethod::class,
            'metadata' => 'array',
        ];
    }

    /**
     * Get the patient associated with the appointment.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Get the doctor associated with the appointment.
     */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Get the schedule associated with the appointment.
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get the user who checked in the patient.
     */
    public function checkedInByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    /**
     * Get the queue ticket associated with the appointment.
     */
    public function queueTicket(): HasOne
    {
        return $this->hasOne(QueueTicket::class);
    }

    /**
     * Generate unique booking code.
     */
    public static function generateBookingCode(): string
    {
        $dateStr = now()->format('Ymd');
        $randomStr = strtoupper(substr(uniqid(), -4));

        return "APT-{$dateStr}-{$randomStr}";
    }
}
