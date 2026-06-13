<?php

namespace App\Services;

use App\Enums\ComplexityLevel;
use App\Enums\OrderStatus;
use App\Enums\UrgencyLevel;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Models\Order;
use App\Models\TailoringService;
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
            $tailoringService = TailoringService::query()
                ->with('measurementTypes')
                ->findOrFail($data['tailoring_service_id']);
            $clothingModel = $tailoringService->requires_model
                ? ClothingModel::query()->findOrFail($data['clothing_model_id'])
                : null;
            $material = $tailoringService->requires_material
                ? Material::query()->findOrFail($data['material_id'])
                : null;
            $complexity = ComplexityLevel::from($data['complexity'] ?? ComplexityLevel::Simple->value);
            $urgency = UrgencyLevel::from($data['urgency'] ?? UrgencyLevel::Standard->value);
            $measurements = $this->cleanMeasurementValues($tailoringService, $data['measurement_values'] ?? []);
            $parameters = $this->cleanKeyValueData($data['parameters'] ?? []);
            $quantity = max(1, (int) ($data['quantity'] ?? 1));

            $order = Order::query()->create([
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $customer->id,
                'clothing_model_id' => $clothingModel?->id,
                'tailoring_service_id' => $tailoringService->id,
                'material_id' => $material?->id,
                'status' => OrderStatus::New,
                'quantity' => $quantity,
                'complexity' => $complexity,
                'urgency' => $urgency,
                'measurements' => $measurements,
                'parameters' => $parameters,
                'customer_comment' => $data['customer_comment'] ?? null,
                'preliminary_price' => $this->calculator->calculate(
                    $tailoringService,
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

            return $order->load(['clothingModel', 'tailoringService', 'material', 'referenceImages']);
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

    /**
     * @param  array<int|string, mixed>  $values
     * @return array<string, mixed>
     */
    private function cleanMeasurementValues(TailoringService $service, array $values): array
    {
        if (! $service->requires_measurements || $service->measurementTypes->isEmpty()) {
            return [];
        }

        $result = [];

        foreach ($service->measurementTypes as $type) {
            $value = $values[$type->id] ?? null;

            if ($value === null || $value === '') {
                continue;
            }

            $result[$type->name] = is_numeric($value) ? (float) $value : trim((string) $value);
        }

        return $result;
    }
}
