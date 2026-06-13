<?php

namespace Database\Seeders;

use App\Enums\ComplexityLevel;
use App\Enums\OrderStatus;
use App\Enums\UrgencyLevel;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Models\Order;
use App\Models\TailoringService;
use App\Models\User;
use App\Services\OrderPriceCalculator;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customer = User::query()->where('email', 'customer@atelier.test')->firstOrFail();
        $master = User::query()->where('email', 'master@atelier.test')->firstOrFail();
        $dress = ClothingModel::query()->where('slug', 'classic-dress')->firstOrFail();
        $shirt = ClothingModel::query()->where('slug', 'mens-shirt')->firstOrFail();
        $cotton = Material::query()->where('name', 'Хлопок')->firstOrFail();
        $silk = Material::query()->where('name', 'Шелк')->firstOrFail();
        $customTailoring = TailoringService::query()->where('slug', 'custom-tailoring')->firstOrFail();
        $occasionLook = TailoringService::query()->where('slug', 'occasion-look')->firstOrFail();
        $calculator = app(OrderPriceCalculator::class);

        foreach ([
            [
                'order_number' => 'AT-20260613-00001',
                'customer_id' => $customer->id,
                'master_id' => $master->id,
                'clothing_model_id' => $dress->id,
                'tailoring_service_id' => $occasionLook->id,
                'material_id' => $silk->id,
                'status' => OrderStatus::Confirmed,
                'quantity' => 1,
                'complexity' => ComplexityLevel::Medium,
                'urgency' => UrgencyLevel::Standard,
                'measurements' => ['Рост' => 168, 'Обхват груди' => 88, 'Обхват талии' => 70],
                'parameters' => ['Длина изделия' => 'миди', 'Рукав' => '3/4'],
                'customer_comment' => 'Нужна спокойная посадка, без глубокого выреза.',
                'admin_comment' => 'Назначена первая примерка.',
            ],
            [
                'order_number' => 'AT-20260613-00002',
                'customer_id' => $customer->id,
                'master_id' => null,
                'clothing_model_id' => $shirt->id,
                'tailoring_service_id' => $customTailoring->id,
                'material_id' => $cotton->id,
                'status' => OrderStatus::New,
                'quantity' => 2,
                'complexity' => ComplexityLevel::Simple,
                'urgency' => UrgencyLevel::Fast,
                'measurements' => ['Рост' => 182, 'Обхват груди' => 104, 'Длина рукава' => 64],
                'parameters' => ['Воротник' => 'классический', 'Манжеты' => 'на пуговицах'],
                'customer_comment' => 'Две одинаковые рубашки в разных цветах.',
                'admin_comment' => null,
            ],
        ] as $orderData) {
            $model = ClothingModel::query()->findOrFail($orderData['clothing_model_id']);
            $service = TailoringService::query()->findOrFail($orderData['tailoring_service_id']);
            $material = Material::query()->findOrFail($orderData['material_id']);

            Order::query()->updateOrCreate(
                ['order_number' => $orderData['order_number']],
                [
                    ...$orderData,
                    'preliminary_price' => $calculator->calculate(
                        $service,
                        $model,
                        $material,
                        $orderData['complexity'],
                        $orderData['urgency'],
                        $orderData['quantity'],
                        $orderData['parameters'],
                    ),
                ],
            );
        }
    }
}
