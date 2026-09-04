<?php

namespace App\Filament\Resources\ServiceCounters\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceCounterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('Counter / Room Name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('code')
                    ->label(__('Counter Code'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                TextInput::make('location')
                    ->label(__('Location / Floor'))
                    ->maxLength(255),
                Toggle::make('is_active')
                    ->label(__('Active Status'))
                    ->default(true),
            ]);
    }
}
