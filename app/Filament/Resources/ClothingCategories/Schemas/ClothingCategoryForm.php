<?php

namespace App\Filament\Resources\ClothingCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ClothingCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Название')->required()->maxLength(255),
                TextInput::make('slug')->label('Slug')->required()->maxLength(255)->unique(ignoreRecord: true),
                Textarea::make('description')->label('Описание')->rows(4)->columnSpanFull(),
                TextInput::make('sort_order')->label('Сортировка')->numeric()->default(0),
                Toggle::make('is_active')->label('Активна')->default(true),
            ]);
    }
}
