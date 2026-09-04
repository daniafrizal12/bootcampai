<?php

namespace App\Filament\Resources\QueueTickets\Tables;

use App\Enums\QueuePriority;
use App\Enums\QueueStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class QueueTicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('display_number')
                    ->label(__('Queue Number'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('queue_date')
                    ->label(__('Date'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('doctor.name')
                    ->label(__('Doctor'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('appointment.patient.name')
                    ->label(__('Patient'))
                    ->searchable(),
                TextColumn::make('priority')
                    ->label(__('Priority'))
                    ->badge()
                    ->color(fn ($state) => $state instanceof QueuePriority ? $state->getColor() : (QueuePriority::tryFrom($state)?->getColor() ?? 'gray'))
                    ->formatStateUsing(fn ($state) => $state instanceof QueuePriority ? $state->getLabel() : (QueuePriority::tryFrom($state)?->getLabel() ?? $state)),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn ($state) => $state instanceof QueueStatus ? $state->getColor() : (QueueStatus::tryFrom($state)?->getColor() ?? 'gray'))
                    ->formatStateUsing(fn ($state) => $state instanceof QueueStatus ? $state->getLabel() : (QueueStatus::tryFrom($state)?->getLabel() ?? $state)),
                TextColumn::make('counter')
                    ->label(__('Counter / Room')),
                TextColumn::make('call_count')
                    ->label(__('Calls'))
                    ->alignCenter(),
                TextColumn::make('called_at')
                    ->label(__('Called At'))
                    ->time('H:i'),
                TextColumn::make('served_at')
                    ->label(__('Served At'))
                    ->time('H:i'),
                TextColumn::make('completed_at')
                    ->label(__('Completed At'))
                    ->time('H:i'),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(QueueStatus::class)
                    ->label(__('Status')),
                SelectFilter::make('priority')
                    ->options(QueuePriority::class)
                    ->label(__('Priority')),
                SelectFilter::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->label(__('Doctor')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
