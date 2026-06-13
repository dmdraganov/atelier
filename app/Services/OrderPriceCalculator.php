<?php

namespace App\Services;

use App\Enums\ComplexityLevel;
use App\Enums\ServicePricingMode;
use App\Enums\UrgencyLevel;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Models\TailoringService;

class OrderPriceCalculator
{
    /**
     * @param  array<string, mixed>  $parameters
     */
    public function calculate(
        TailoringService $tailoringService,
        ?ClothingModel $clothingModel,
        ?Material $material,
        ComplexityLevel $complexity,
        UrgencyLevel $urgency,
        int $quantity = 1,
        array $parameters = [],
    ): float {
        $optionsPrice = (float) ($parameters['options_price'] ?? 0);
        $modelPrice = $clothingModel ? (float) $clothingModel->base_price * (float) $tailoringService->model_price_factor : 0.0;
        $materialPrice = $material ? (float) $material->price_modifier : 0.0;
        $quantityFactor = $tailoringService->applies_quantity ? max(1, $quantity) : 1;
        $complexityFactor = $tailoringService->applies_complexity ? $complexity->multiplier() : 1.0;
        $urgencyFactor = $tailoringService->applies_urgency ? $urgency->multiplier() : 1.0;

        $basePrice = match ($tailoringService->pricing_mode) {
            ServicePricingMode::ModelBased => (float) $tailoringService->base_price + $modelPrice + $materialPrice + $optionsPrice,
            ServicePricingMode::Alteration => (float) $tailoringService->base_price + $modelPrice + $optionsPrice,
            ServicePricingMode::Fixed => (float) $tailoringService->base_price + $optionsPrice,
        };

        $price = $basePrice * $complexityFactor * $urgencyFactor * $quantityFactor;

        return round($price, 2);
    }
}
