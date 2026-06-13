<?php

namespace Tests\Unit;

use App\Enums\ComplexityLevel;
use App\Enums\ServicePricingMode;
use App\Enums\UrgencyLevel;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Models\TailoringService;
use App\Services\OrderPriceCalculator;
use PHPUnit\Framework\TestCase;

class OrderPriceCalculatorTest extends TestCase
{
    public function test_it_calculates_preliminary_price_from_single_service(): void
    {
        $model = new ClothingModel(['base_price' => 10000]);
        $service = new TailoringService([
            'pricing_mode' => ServicePricingMode::ModelBased,
            'base_price' => 6000,
            'model_price_factor' => 1,
            'applies_complexity' => true,
            'applies_urgency' => true,
            'applies_quantity' => true,
        ]);
        $material = new Material(['price_modifier' => 2000]);

        $price = (new OrderPriceCalculator)->calculate(
            $service,
            $model,
            $material,
            ComplexityLevel::Complex,
            UrgencyLevel::Fast,
            2,
            ['options_price' => 500],
        );

        $this->assertSame(66600.0, $price);
    }
}
