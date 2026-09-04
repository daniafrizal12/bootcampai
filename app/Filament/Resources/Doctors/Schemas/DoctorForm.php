<?php

namespace App\Filament\Resources\Doctors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class DoctorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Doctor Name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('license_number')
                    ->label(__('License Number (STR)'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('specialty')
                    ->label(__('Specialty'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->label(__('Email'))
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                TextInput::make('password')
                    ->label(__('Password'))
                    ->password()
                    ->revealable()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrated(fn (?string $state): bool => filled($state)),
                TextInput::make('phone')
                    ->label(__('Phone Number'))
                    ->tel()
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label(__('Active Status'))
                    ->default(true),
                Textarea::make('bio')
                    ->label(__('Short Bio'))
                    ->columnSpanFull(),
                FileUpload::make('photo')
                    ->label(__('Doctor Photo'))
                    ->image()
                    ->disk('public')
                    ->imageEditor()
                    ->directory('doctors')
                    ->columnSpanFull(),
            ]);
    }
}
