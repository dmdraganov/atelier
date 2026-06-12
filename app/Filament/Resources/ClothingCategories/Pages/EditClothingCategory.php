<?php

namespace App\Filament\Resources\ClothingCategories\Pages;

use App\Filament\Resources\ClothingCategories\ClothingCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditClothingCategory extends EditRecord
{
    protected static string $resource = ClothingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
