<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\ComplexityLevel;
use App\Enums\OrderStatus;
use App\Enums\UrgencyLevel;
use App\Enums\UserRole;
use App\Models\User;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')->label('Номер')->required()->maxLength(255)->unique(ignoreRecord: true),
                Select::make('customer_id')
                    ->label('Клиент')
                    ->relationship('customer', 'name', fn ($query) => $query->where('role', UserRole::Customer->value))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('master_id')
                    ->label('Мастер')
                    ->options(fn (): array => User::query()->where('role', UserRole::Master->value)->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload(),
                Select::make('clothing_model_id')->label('Модель')->relationship('clothingModel', 'name')->searchable()->preload()->required(),
                Select::make('material_id')->label('Материал')->relationship('material', 'name')->searchable()->preload()->required(),
                Select::make('status')
                    ->label('Статус')
                    ->options(collect(OrderStatus::cases())->mapWithKeys(fn (OrderStatus $status): array => [$status->value => $status->label()])->all())
                    ->required(),
                TextInput::make('quantity')->label('Количество')->numeric()->required()->minValue(1),
                Select::make('complexity')
                    ->label('Сложность')
                    ->options(collect(ComplexityLevel::cases())->mapWithKeys(fn (ComplexityLevel $level): array => [$level->value => $level->label()])->all())
                    ->required(),
                Select::make('urgency')
                    ->label('Срочность')
                    ->options(collect(UrgencyLevel::cases())->mapWithKeys(fn (UrgencyLevel $level): array => [$level->value => $level->label()])->all())
                    ->required(),
                KeyValue::make('measurements')->label('Мерки')->columnSpanFull(),
                KeyValue::make('parameters')->label('Параметры')->columnSpanFull(),
                Textarea::make('customer_comment')->label('Комментарий клиента')->rows(4)->columnSpanFull(),
                Textarea::make('admin_comment')->label('Комментарий администратора')->rows(4)->columnSpanFull(),
                TextInput::make('preliminary_price')
                    ->label('Предварительная цена')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),
                TextInput::make('final_price')->label('Финальная цена')->numeric()->minValue(0),
            ]);
    }
}
