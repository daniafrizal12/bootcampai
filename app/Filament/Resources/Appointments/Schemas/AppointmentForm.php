<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Enums\AppointmentSource;
use App\Enums\AppointmentStatus;
use App\Enums\VisitType;
use App\Models\Appointment;
use App\Models\Schedule;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('booking_code')
                    ->label(__('Booking Code'))
                    ->default(fn () => Appointment::generateBookingCode())
                    ->readOnly()
                    ->required(),
                Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label(__('Patient')),
                Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->live()
                    ->label(__('Doctor')),
                Select::make('schedule_id')
                    ->label(__('Doctor Schedule'))
                    ->options(fn ($get) => $get('doctor_id')
                        ? Schedule::query()
                            ->where('doctor_id', $get('doctor_id'))
                            ->where('status', 'active')
                            ->get()
                            ->mapWithKeys(fn ($s) => [$s->id => ($s->day_name ?? $s->specific_date?->format('d/m/Y')) . " ({$s->start_time} - {$s->end_time})"])
                            ->toArray()
                        : []
                    )
                    ->searchable()
                    ->nullable(),
                DatePicker::make('appointment_date')
                    ->label(__('Appointment Date'))
                    ->default(now())
                    ->required(),
                TimePicker::make('estimated_time')
                    ->label(__('Estimated Service Time'))
                    ->seconds(false),
                Select::make('visit_type')
                    ->label(__('Visit Type'))
                    ->options(VisitType::class)
                    ->default(VisitType::NewVisit)
                    ->required(),
                Select::make('source')
                    ->label(__('Registration Source'))
                    ->options(AppointmentSource::class)
                    ->default(AppointmentSource::WalkIn)
                    ->required(),
                Select::make('status')
                    ->label(__('Appointment Status'))
                    ->options(AppointmentStatus::class)
                    ->default(AppointmentStatus::Pending)
                    ->live()
                    ->required(),
                Textarea::make('chief_complaint')
                    ->label(__('Chief Complaint')),
                Textarea::make('patient_notes')
                    ->label(__('Patient Notes')),
                Textarea::make('cancellation_reason')
                    ->label(__('Cancellation Reason'))
                    ->visible(fn ($get) => in_array($get('status'), [AppointmentStatus::Cancelled->value, AppointmentStatus::Cancelled]))
                    ->required(fn ($get) => in_array($get('status'), [AppointmentStatus::Cancelled->value, AppointmentStatus::Cancelled]))
                    ->columnSpanFull(),
            ]);
    }
}
