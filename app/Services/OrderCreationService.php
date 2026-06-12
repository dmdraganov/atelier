<?php

namespace App\Services;

use App\Enums\ComplexityLevel;
use App\Enums\OrderStatus;
use App\Enums\UrgencyLevel;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class OrderCreationService
{
    public function __construct(
        private readonly OrderPriceCalculator $calculator,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function create(User $customer, array $data): Order
    {
        return DB::transaction(function () use ($customer, $data): Order {
            $clothingModel = ClothingModel::query()->findOrFail($data['clothing_model_id']);
            $material = Material::query()->findOrFail($data['material_id']);
            $complexity = ComplexityLevel::from($data['complexity']);
            $urgency = UrgencyLevel::from($data['urgency']);
            $measurements = $this->cleanKeyValueData($data['measurements'] ?? []);
            $parameters = $this->cleanKeyValueData($data['parameters'] ?? []);
            $quantity = max(1, (int) $data['quantity']);

            $order = Order::query()->create([
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $customer->id,
                'clothing_model_id' => $clothingModel->id,
                'material_id' => $material->id,
                'status' => OrderStatus::New,
                'quantity' => $quantity,
                'complexity' => $complexity,
                'urgency' => $urgency,
                'measurements' => $measurements,
                'parameters' => $parameters,
                'customer_comment' => $data['customer_comment'] ?? null,
                'preliminary_price' => $this->calculator->calculate(
                    $clothingModel,
                    $material,
                    $complexity,
                    $urgency,
                    $quantity,
                    $parameters,
                ),
            ]);

            foreach ($data['reference_images'] ?? [] as $image) {
                if (! $image instanceof UploadedFile) {
                    continue;
                }

                $path = $image->store('order-references/'.$order->id, 'public');

                $order->referenceImages()->create([
                    'file_path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                    'mime_type' => $image->getClientMimeType(),
                    'size' => $image->getSize(),
                ]);
            }

            return $order->load(['clothingModel', 'material', 'referenceImages']);
        });
    }

    private function generateOrderNumber(): string
    {
        $nextId = ((int) Order::query()->max('id')) + 1;

        return 'AT-'.now()->format('Ymd').'-'.str_pad((string) $nextId, 5, '0', STR_PAD_LEFT);
    }

    /**
     * @param  array<string, mixed>|array<int, array<string, mixed>>  $items
     * @return array<string, mixed>
     */
    private function cleanKeyValueData(array $items): array
    {
        $result = [];

        foreach ($items as $key => $value) {
            if (is_array($value) && array_key_exists('key', $value)) {
                $key = trim((string) $value['key']);
                $value = $value['value'] ?? null;
            }

            if ($key === '' || $value === null || $value === '') {
                continue;
            }

            $result[(string) $key] = is_numeric($value) ? (float) $value : $value;
        }

        return $result;
    }
}
