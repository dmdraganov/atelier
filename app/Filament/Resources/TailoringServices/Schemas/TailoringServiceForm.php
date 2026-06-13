<?php

namespace App\Filament\Resources\TailoringServices\Schemas;

use App\Enums\ServicePricingMode;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TailoringServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Название')->required()->maxLength(255),
                TextInput::make('slug')->label('Slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                Textarea::make('description')->label('Описание')->rows(4)->columnSpanFull(),
                Select::make('pricing_mode')
                    ->label('Режим расчёта')
                    ->options(collect(ServicePricingMode::cases())->mapWithKeys(fn (ServicePricingMode $mode): array => [$mode->value => $mode->label()])->all())
                    ->required(),
                TextInput::make('base_price')->label('Базовая цена услуги')->numeric()->required()->minValue(0),
                TextInput::make('model_price_factor')
                    ->label('Доля цены модели')
                    ->numeric()
                    ->required()
                    ->minValue(0)
                    ->helperText('1.00 — полная цена модели, 0.20 — 20%, 0 — модель не влияет на цену.'),
                TextInput::make('price_modifier')->label('Старая наценка')->numeric()->required()->minValue(0)->disabled()->dehydrated(false),
                TextInput::make('sort_order')->label('Сортировка')->numeric()->required()->default(0)->minValue(0),
                Toggle::make('requires_model')->label('Требует модель')->default(true),
                Toggle::make('requires_material')->label('Требует материал')->default(true),
                Toggle::make('requires_measurements')->label('Требует мерки')->default(true),
                Toggle::make('applies_complexity')->label('Учитывать сложность')->default(true),
                Toggle::make('applies_urgency')->label('Учитывать срочность')->default(true),
                Toggle::make('applies_quantity')->label('Учитывать количество')->default(true),
                Select::make('measurementTypes')
                    ->label('Мерки для услуги')
                    ->relationship('measurementTypes', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Select::make('clothingModels')
                    ->label('Подходящие модели')
                    ->relationship('clothingModels', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->columnSpanFull(),
                Toggle::make('is_active')->label('Активна')->default(true),
            ]);
    }
}
