<?php

namespace App\Filament\Resources\Appointments\Tables;

use App\Enums\AppointmentSource;
use App\Enums\AppointmentStatus;
use App\Enums\VisitType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AppointmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_code')
                    ->label(__('Booking Code'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('patient.name')
                    ->label(__('Patient'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('doctor.name')
                    ->label(__('Doctor'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('appointment_date')
                    ->label(__('Appointment Date'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('estimated_time')
                    ->label(__('Estimated Time'))
                    ->time('H:i'),
                TextColumn::make('visit_type')
                    ->label(__('Visit Type'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof VisitType ? $state->getLabel() : (VisitType::tryFrom($state)?->getLabel() ?? $state)),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn ($state) => $state instanceof AppointmentStatus ? $state->getColor() : (AppointmentStatus::tryFrom($state)?->getColor() ?? 'gray'))
                    ->formatStateUsing(fn ($state) => $state instanceof AppointmentStatus ? $state->getLabel() : (AppointmentStatus::tryFrom($state)?->getLabel() ?? $state)),
                TextColumn::make('source')
                    ->label(__('Source'))
                    ->formatStateUsing(fn ($state) => $state instanceof AppointmentSource ? $state->getLabel() : (AppointmentSource::tryFrom($state)?->getLabel() ?? $state)),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(AppointmentStatus::class)
                    ->label(__('Status')),
                SelectFilter::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->label(__('Doctor')),
                SelectFilter::make('visit_type')
                    ->options(VisitType::class)
                    ->label(__('Visit Type')),
                SelectFilter::make('source')
                    ->options(AppointmentSource::class)
                    ->label(__('Source')),
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
