<?php

namespace App\Filament\Resources\MeasurementTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MeasurementTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Название')->required()->maxLength(255),
                TextInput::make('slug')->label('Slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                TextInput::make('unit')->label('Единица')->maxLength(50),
                TextInput::make('help_text')->label('Подсказка')->maxLength(255)->columnSpanFull(),
                TextInput::make('sort_order')->label('Сортировка')->numeric()->required()->default(0)->minValue(0),
                Toggle::make('is_required')->label('Обязательная')->default(false),
                Toggle::make('is_active')->label('Активна')->default(true),
            ]);
    }
}
