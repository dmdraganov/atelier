<?php

namespace App\Filament\Resources\TailoringServices\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TailoringServicesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Название')->searchable()->sortable(),
                TextColumn::make('pricing_mode')->label('Расчёт')->formatStateUsing(fn ($state) => $state->label()),
                TextColumn::make('base_price')->label('Базовая цена')->money('RUB')->sortable(),
                TextColumn::make('model_price_factor')->label('Доля модели')->sortable(),
                TextColumn::make('sort_order')->label('Сортировка')->sortable(),
                IconColumn::make('is_active')->label('Активна')->boolean(),
                TextColumn::make('updated_at')->label('Обновлено')->dateTime('d.m.Y H:i')->sortable(),
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
