<?php

namespace App\Filament\Resources\ClothingCategories\Pages;

use App\Filament\Resources\ClothingCategories\ClothingCategoryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListClothingCategories extends ListRecords
{
    protected static string $resource = ClothingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
