<?php

namespace App\Filament\Resources\Schedules\Schemas;

use App\Enums\ScheduleStatus;
use App\Enums\ScheduleType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ScheduleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label(__('Doctor')),
                Select::make('type')
                    ->label(__('Schedule Type'))
                    ->options(ScheduleType::class)
                    ->default(ScheduleType::Recurring)
                    ->live()
                    ->required(),
                Select::make('day_of_week')
                    ->label(__('Practice Day'))
                    ->options([
                        0 => __('Sunday'),
                        1 => __('Monday'),
                        2 => __('Tuesday'),
                        3 => __('Wednesday'),
                        4 => __('Thursday'),
                        5 => __('Friday'),
                        6 => __('Saturday'),
                    ])
                    ->visible(fn ($get) => $get('type') === ScheduleType::Recurring->value || $get('type') === ScheduleType::Recurring)
                    ->required(fn ($get) => $get('type') === ScheduleType::Recurring->value || $get('type') === ScheduleType::Recurring),
                DatePicker::make('specific_date')
                    ->label(__('Specific Date'))
                    ->visible(fn ($get) => $get('type') === ScheduleType::OneTime->value || $get('type') === ScheduleType::OneTime)
                    ->required(fn ($get) => $get('type') === ScheduleType::OneTime->value || $get('type') === ScheduleType::OneTime),
                TimePicker::make('start_time')
                    ->label(__('Start Time'))
                    ->seconds(false)
                    ->required(),
                TimePicker::make('end_time')
                    ->label(__('End Time'))
                    ->seconds(false)
                    ->required(),
                TextInput::make('max_patients')
                    ->label(__('Patient Quota'))
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(50)
                    ->default(20)
                    ->required(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options(ScheduleStatus::class)
                    ->default(ScheduleStatus::Active)
                    ->required(),
                Textarea::make('notes')
                    ->label(__('Additional Notes'))
                    ->columnSpanFull(),
            ]);
    }
}
