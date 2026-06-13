<?php

namespace App\Filament\Resources\TailoringServices;

use App\Filament\Resources\TailoringServices\Pages\CreateTailoringService;
use App\Filament\Resources\TailoringServices\Pages\EditTailoringService;
use App\Filament\Resources\TailoringServices\Pages\ListTailoringServices;
use App\Filament\Resources\TailoringServices\Schemas\TailoringServiceForm;
use App\Filament\Resources\TailoringServices\Tables\TailoringServicesTable;
use App\Models\TailoringService;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class TailoringServiceResource extends Resource
{
    protected static ?string $model = TailoringService::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScissors;

    protected static ?string $modelLabel = 'Услуга';

    protected static ?string $pluralModelLabel = 'Услуги';

    protected static ?string $navigationLabel = 'Услуги';

    protected static UnitEnum|string|null $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 35;

    public static function form(Schema $schema): Schema
    {
        return TailoringServiceForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TailoringServicesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTailoringServices::route('/'),
            'create' => CreateTailoringService::route('/create'),
            'edit' => EditTailoringService::route('/{record}/edit'),
        ];
    }
}
