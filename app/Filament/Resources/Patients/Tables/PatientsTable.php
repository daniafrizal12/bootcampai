<?php

namespace App\Filament\Resources\Patients\Tables;

use App\Enums\BloodType;
use App\Enums\Gender;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PatientsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('medical_record_number')
                    ->label(__('Medical Record No.'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->label(__('Patient Name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('national_id')
                    ->label(__('National ID (NIK)'))
                    ->searchable(),
                TextColumn::make('phone')
                    ->label(__('Phone'))
                    ->searchable(),
                TextColumn::make('gender')
                    ->label(__('Gender'))
                    ->formatStateUsing(fn ($state) => $state instanceof Gender ? $state->getLabel() : (Gender::tryFrom($state)?->getLabel() ?? $state)),
                TextColumn::make('date_of_birth')
                    ->label(__('Date of Birth'))
                    ->date('d/m/Y')
                    ->sortable(),
                TextColumn::make('blood_type')
                    ->label(__('Blood Grp'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof BloodType ? $state->value : (BloodType::tryFrom($state)?->value ?? $state)),
            ])
            ->filters([
                SelectFilter::make('gender')
                    ->options(Gender::class)
                    ->label(__('Gender')),
                SelectFilter::make('blood_type')
                    ->options(BloodType::class)
                    ->label(__('Blood Type')),
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
