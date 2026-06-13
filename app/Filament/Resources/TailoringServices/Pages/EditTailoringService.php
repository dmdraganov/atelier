<?php

namespace App\Filament\Resources\TailoringServices\Pages;

use App\Filament\Resources\TailoringServices\TailoringServiceResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTailoringService extends EditRecord
{
    protected static string $resource = TailoringServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
