<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')->label('Номер')->searchable()->sortable(),
                TextColumn::make('customer.name')->label('Клиент')->searchable(),
                TextColumn::make('master.name')->label('Мастер')->placeholder('Не назначен'),
                TextColumn::make('clothingModel.name')->label('Модель')->searchable(),
                TextColumn::make('status')->label('Статус')->formatStateUsing(fn ($state) => $state->label())->badge(),
                TextColumn::make('preliminary_price')->label('Предв. цена')->money('RUB')->sortable(),
                TextColumn::make('final_price')->label('Фин. цена')->money('RUB')->placeholder('Не назначена')->sortable(),
                TextColumn::make('created_at')->label('Создан')->dateTime('d.m.Y H:i')->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Статус')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn (OrderStatus $status): array => [$status->value => $status->label()])->all()),
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
