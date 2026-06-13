<?php

namespace App\Filament\Resources\TailoringServices\Pages;

use App\Filament\Resources\TailoringServices\TailoringServiceResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTailoringServices extends ListRecords
{
    protected static string $resource = TailoringServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
