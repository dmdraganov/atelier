<?php

namespace Tests\Unit;

use App\Enums\ComplexityLevel;
use App\Enums\UrgencyLevel;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Services\OrderPriceCalculator;
use PHPUnit\Framework\TestCase;

class OrderPriceCalculatorTest extends TestCase
{
    public function test_it_calculates_preliminary_price_from_single_service(): void
    {
        $model = new ClothingModel(['base_price' => 10000]);
        $material = new Material(['price_modifier' => 2000]);

        $price = (new OrderPriceCalculator)->calculate(
            $model,
            $material,
            ComplexityLevel::Complex,
            UrgencyLevel::Fast,
            2,
            ['options_price' => 500],
        );

        $this->assertSame(45000.0, $price);
    }
}
