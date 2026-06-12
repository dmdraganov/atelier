<?php

namespace App\Filament\Resources\ClothingModels\Schemas;

use App\Enums\ComplexityLevel;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClothingModelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Категория')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')->label('Название')->required()->maxLength(255),
                TextInput::make('slug')->label('Slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                Textarea::make('description')->label('Описание')->rows(4)->columnSpanFull(),
                TextInput::make('image_path')->label('Путь к изображению')->maxLength(255),
                TextInput::make('base_price')->label('Базовая цена')->numeric()->required()->minValue(0),
                Select::make('default_complexity')
                    ->label('Сложность по умолчанию')
                    ->options(collect(ComplexityLevel::cases())->mapWithKeys(fn (ComplexityLevel $level): array => [$level->value => $level->label()])->all())
                    ->required(),
                TextInput::make('estimated_days')->label('Срок, дней')->numeric()->required()->minValue(1),
                TextInput::make('sort_order')->label('Сортировка')->numeric()->default(0),
                Toggle::make('is_active')->label('Активна')->default(true),
            ]);
    }
}
