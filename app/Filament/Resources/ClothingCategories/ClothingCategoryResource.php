<?php

namespace App\Filament\Resources\ClothingCategories;

use App\Filament\Resources\ClothingCategories\Pages\CreateClothingCategory;
use App\Filament\Resources\ClothingCategories\Pages\EditClothingCategory;
use App\Filament\Resources\ClothingCategories\Pages\ListClothingCategories;
use App\Filament\Resources\ClothingCategories\Schemas\ClothingCategoryForm;
use App\Filament\Resources\ClothingCategories\Tables\ClothingCategoriesTable;
use App\Models\ClothingCategory;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ClothingCategoryResource extends Resource
{
    protected static ?string $model = ClothingCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $modelLabel = 'Категория';

    protected static ?string $pluralModelLabel = 'Категории';

    protected static ?string $navigationLabel = 'Категории';

    protected static UnitEnum|string|null $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return ClothingCategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClothingCategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListClothingCategories::route('/'),
            'create' => CreateClothingCategory::route('/create'),
            'edit' => EditClothingCategory::route('/{record}/edit'),
        ];
    }
}
