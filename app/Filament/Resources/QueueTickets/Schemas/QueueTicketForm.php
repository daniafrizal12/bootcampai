<?php

namespace App\Filament\Resources\QueueTickets\Schemas;

use App\Enums\QueuePriority;
use App\Enums\QueueStatus;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class QueueTicketForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('appointment_id')
                    ->relationship('appointment', 'booking_code')
                    ->searchable()
                    ->nullable()
                    ->label(__('Booking Code')),
                Select::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label(__('Doctor')),
                DatePicker::make('queue_date')
                    ->label(__('Queue Date'))
                    ->default(now())
                    ->required(),
                TextInput::make('prefix')
                    ->label(__('Queue Prefix'))
                    ->default('A')
                    ->maxLength(5)
                    ->required(),
                TextInput::make('queue_number')
                    ->label(__('Order Number'))
                    ->numeric()
                    ->required(),
                TextInput::make('display_number')
                    ->label(__('Display Number'))
                    ->required(),
                Select::make('priority')
                    ->label(__('Priority'))
                    ->options(QueuePriority::class)
                    ->default(QueuePriority::Normal)
                    ->required(),
                Select::make('status')
                    ->label(__('Status'))
                    ->options(QueueStatus::class)
                    ->default(QueueStatus::Waiting)
                    ->required(),
                TextInput::make('counter')
                    ->label(__('Service Counter / Room'))
                    ->maxLength(255),
                TextInput::make('call_count')
                    ->label(__('Call Count'))
                    ->numeric()
                    ->default(0),
                Textarea::make('notes')
                    ->label(__('Queue Notes'))
                    ->columnSpanFull(),
            ]);
    }
}
