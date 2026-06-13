<?php

namespace App\Filament\Resources\MeasurementTypes\Pages;

use App\Filament\Resources\MeasurementTypes\MeasurementTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMeasurementTypes extends ListRecords
{
    protected static string $resource = MeasurementTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
