<?php

namespace App\Filament\Resources\Schedules\Tables;

use App\Enums\ScheduleStatus;
use App\Enums\ScheduleType;
use App\Models\Schedule;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('doctor.name')
                    ->label(__('Doctor'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('type')
                    ->label(__('Schedule Type'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof ScheduleType ? $state->getLabel() : (ScheduleType::tryFrom($state)?->getLabel() ?? $state)),
                TextColumn::make('day_name')
                    ->label(__('Day / Date'))
                    ->state(fn (Schedule $record) => $record->type === ScheduleType::Recurring ? ($record->day_name ?? '-') : ($record->specific_date?->format('d/m/Y') ?? '-')),
                TextColumn::make('start_time')
                    ->label(__('Start'))
                    ->time('H:i'),
                TextColumn::make('end_time')
                    ->label(__('End'))
                    ->time('H:i'),
                TextColumn::make('max_patients')
                    ->label(__('Quota'))
                    ->alignCenter(),
                TextColumn::make('status')
                    ->label(__('Status'))
                    ->badge()
                    ->color(fn ($state) => $state instanceof ScheduleStatus ? $state->getColor() : (ScheduleStatus::tryFrom($state)?->getColor() ?? 'gray'))
                    ->formatStateUsing(fn ($state) => $state instanceof ScheduleStatus ? $state->getLabel() : (ScheduleStatus::tryFrom($state)?->getLabel() ?? $state)),
            ])
            ->filters([
                SelectFilter::make('doctor_id')
                    ->relationship('doctor', 'name')
                    ->label(__('Doctor')),
                SelectFilter::make('status')
                    ->options(ScheduleStatus::class)
                    ->label(__('Status')),
                SelectFilter::make('type')
                    ->options(ScheduleType::class)
                    ->label(__('Schedule Type')),
                SelectFilter::make('day_of_week')
                    ->label(__('Practice Day'))
                    ->options([
                        0 => __('Sunday'),
                        1 => __('Monday'),
                        2 => __('Tuesday'),
                        3 => __('Wednesday'),
                        4 => __('Thursday'),
                        5 => __('Friday'),
                        6 => __('Saturday'),
                    ]),
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
