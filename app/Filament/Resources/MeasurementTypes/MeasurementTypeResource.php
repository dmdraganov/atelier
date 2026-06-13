<?php

namespace App\Filament\Resources\MeasurementTypes;

use App\Filament\Resources\MeasurementTypes\Pages\CreateMeasurementType;
use App\Filament\Resources\MeasurementTypes\Pages\EditMeasurementType;
use App\Filament\Resources\MeasurementTypes\Pages\ListMeasurementTypes;
use App\Filament\Resources\MeasurementTypes\Schemas\MeasurementTypeForm;
use App\Filament\Resources\MeasurementTypes\Tables\MeasurementTypesTable;
use App\Models\MeasurementType;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class MeasurementTypeResource extends Resource
{
    protected static ?string $model = MeasurementType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static ?string $modelLabel = 'Мерка';

    protected static ?string $pluralModelLabel = 'Мерки';

    protected static ?string $navigationLabel = 'Мерки';

    protected static UnitEnum|string|null $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 45;

    public static function form(Schema $schema): Schema
    {
        return MeasurementTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MeasurementTypesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMeasurementTypes::route('/'),
            'create' => CreateMeasurementType::route('/create'),
            'edit' => EditMeasurementType::route('/{record}/edit'),
        ];
    }
}
