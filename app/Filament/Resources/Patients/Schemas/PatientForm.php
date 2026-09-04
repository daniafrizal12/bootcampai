<?php

namespace App\Filament\Resources\Patients\Schemas;

use App\Enums\BloodType;
use App\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PatientForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('medical_record_number')
                    ->label(__('Medical Record Number'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->default(fn () => 'RM-' . date('Ymd') . '-' . rand(1000, 9999))
                    ->maxLength(255),
                TextInput::make('name')
                    ->label(__('Patient Name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('national_id')
                    ->label(__('National ID (NIK)'))
                    ->maxLength(20)
                    ->unique(ignoreRecord: true),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                TextInput::make('phone')
                    ->label(__('Phone Number'))
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Select::make('gender')
                    ->label(__('Gender'))
                    ->options(Gender::class)
                    ->required(),
                DatePicker::make('date_of_birth')
                    ->label(__('Date of Birth'))
                    ->required(),
                Select::make('blood_type')
                    ->label(__('Blood Type'))
                    ->options(BloodType::class),
                Textarea::make('address')
                    ->label(__('Full Address'))
                    ->columnSpanFull(),
                TagsInput::make('allergies')
                    ->label(__('Allergy History'))
                    ->placeholder(__('Type allergy and press enter'))
                    ->columnSpanFull(),
                FileUpload::make('photo')
                    ->label(__('Patient Photo'))
                    ->image()
                    ->disk('public')
                    ->directory('patients')
                    ->columnSpanFull(),
            ]);
    }
}
