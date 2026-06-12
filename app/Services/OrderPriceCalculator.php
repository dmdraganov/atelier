<?php

namespace App\Services;

use App\Enums\ComplexityLevel;
use App\Enums\UrgencyLevel;
use App\Models\ClothingModel;
use App\Models\Material;

class OrderPriceCalculator
{
    /**
     * @param  array<string, mixed>  $parameters
     */
    public function calculate(
        ClothingModel $clothingModel,
        Material $material,
        ComplexityLevel $complexity,
        UrgencyLevel $urgency,
        int $quantity = 1,
        array $parameters = [],
    ): float {
        $optionsPrice = (float) ($parameters['options_price'] ?? 0);

        $price = ((float) $clothingModel->base_price + (float) $material->price_modifier + $optionsPrice)
            * $complexity->multiplier()
            * $urgency->multiplier()
            * max(1, $quantity);

        return round($price, 2);
    }
}
