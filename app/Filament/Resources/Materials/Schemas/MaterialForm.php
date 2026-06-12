<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Название')->required()->maxLength(255),
                Textarea::make('description')->label('Описание')->rows(4)->columnSpanFull(),
                TextInput::make('price_modifier')->label('Наценка')->numeric()->required()->minValue(0),
                Toggle::make('is_active')->label('Активен')->default(true),
            ]);
    }
}
