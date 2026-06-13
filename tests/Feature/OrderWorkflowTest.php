<?php

namespace Tests\Feature;

use App\Enums\ComplexityLevel;
use App\Enums\OrderStatus;
use App\Enums\ServicePricingMode;
use App\Enums\UrgencyLevel;
use App\Models\ClothingCategory;
use App\Models\ClothingModel;
use App\Models\MeasurementType;
use App\Models\Material;
use App\Models\Order;
use App\Models\TailoringService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class OrderWorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_customer_can_create_order_with_reference_image(): void
    {
        Storage::fake('public');

        $customer = User::factory()->customer()->create();
        [$model, $service, $material, $measurement] = $this->catalog();

        $response = $this->actingAs($customer)->post(route('orders.store'), [
            'clothing_model_id' => $model->id,
            'tailoring_service_id' => $service->id,
            'material_id' => $material->id,
            'quantity' => 2,
            'complexity' => ComplexityLevel::Medium->value,
            'urgency' => UrgencyLevel::Fast->value,
            'measurement_values' => [
                $measurement->id => '170',
            ],
            'parameters' => [
                ['key' => 'Длина', 'value' => 'миди'],
            ],
            'customer_comment' => 'Нужна примерка.',
            'reference_images' => [
                UploadedFile::fake()->create('reference.jpg', 100, 'image/jpeg'),
            ],
        ]);

        $order = Order::query()->firstOrFail();

        $response->assertRedirect(route('orders.show', $order));
        $this->assertSame(OrderStatus::New, $order->status);
        $this->assertSame($service->id, $order->tailoring_service_id);
        $this->assertSame('Рост', array_key_first($order->measurements));
        $this->assertSame('Длина', array_key_first($order->parameters));
        $this->assertEquals(43500.0, (float) $order->preliminary_price);
        $this->assertCount(1, $order->referenceImages);
        Storage::disk('public')->assertExists($order->referenceImages->first()->file_path);
    }

    public function test_customer_can_create_fixed_consultation_without_model_material_or_measurements(): void
    {
        $customer = User::factory()->customer()->create();
        $service = TailoringService::query()->create([
            'name' => 'Консультация по ткани и фасону',
            'slug' => 'fabric-style-consultation',
            'pricing_mode' => ServicePricingMode::Fixed,
            'base_price' => 2500,
            'model_price_factor' => 0,
            'requires_model' => false,
            'requires_material' => false,
            'requires_measurements' => false,
            'applies_complexity' => false,
            'applies_urgency' => false,
            'applies_quantity' => false,
            'is_active' => true,
        ]);

        $response = $this->actingAs($customer)->post(route('orders.store'), [
            'tailoring_service_id' => $service->id,
            'quantity' => 20,
            'complexity' => ComplexityLevel::Complex->value,
            'urgency' => UrgencyLevel::Urgent->value,
            'customer_comment' => 'Нужна консультация по ткани.',
        ]);

        $order = Order::query()->firstOrFail();

        $response->assertRedirect(route('orders.show', $order));
        $this->assertNull($order->clothing_model_id);
        $this->assertNull($order->material_id);
        $this->assertSame([], $order->measurements);
        $this->assertEquals(2500.0, (float) $order->preliminary_price);
    }

    public function test_customer_cannot_view_another_customer_order(): void
    {
        $owner = User::factory()->customer()->create();
        $other = User::factory()->customer()->create();
        [$model, $service, $material] = $this->catalog();

        $order = Order::query()->create([
            'order_number' => 'AT-TEST-00001',
            'customer_id' => $owner->id,
            'clothing_model_id' => $model->id,
            'tailoring_service_id' => $service->id,
            'material_id' => $material->id,
            'status' => OrderStatus::New,
            'quantity' => 1,
            'complexity' => ComplexityLevel::Simple,
            'urgency' => UrgencyLevel::Standard,
            'preliminary_price' => 10000,
        ]);

        $this->actingAs($other)->get(route('orders.show', $order))->assertForbidden();
    }

    public function test_master_sees_only_assigned_order(): void
    {
        $customer = User::factory()->customer()->create();
        $master = User::factory()->master()->create();
        $anotherMaster = User::factory()->master()->create();
        [$model, $service, $material] = $this->catalog();

        $assigned = Order::query()->create([
            'order_number' => 'AT-TEST-00002',
            'customer_id' => $customer->id,
            'master_id' => $master->id,
            'clothing_model_id' => $model->id,
            'tailoring_service_id' => $service->id,
            'material_id' => $material->id,
            'status' => OrderStatus::Confirmed,
            'quantity' => 1,
            'complexity' => ComplexityLevel::Simple,
            'urgency' => UrgencyLevel::Standard,
            'preliminary_price' => 10000,
        ]);

        $unassigned = Order::query()->create([
            'order_number' => 'AT-TEST-00003',
            'customer_id' => $customer->id,
            'master_id' => $anotherMaster->id,
            'clothing_model_id' => $model->id,
            'tailoring_service_id' => $service->id,
            'material_id' => $material->id,
            'status' => OrderStatus::Confirmed,
            'quantity' => 1,
            'complexity' => ComplexityLevel::Simple,
            'urgency' => UrgencyLevel::Standard,
            'preliminary_price' => 10000,
        ]);

        $this->actingAs($master)->get(route('master.orders.show', $assigned))->assertOk();
        $this->actingAs($master)->get(route('master.orders.show', $unassigned))->assertForbidden();
    }

    public function test_only_admin_can_access_filament_panel(): void
    {
        $admin = User::factory()->admin()->create();
        $customer = User::factory()->customer()->create();

        $this->assertTrue($admin->canAccessPanel(filament()->getPanel('admin')));
        $this->assertFalse($customer->canAccessPanel(filament()->getPanel('admin')));
    }

    public function test_customer_order_routes_are_limited_to_customers(): void
    {
        $master = User::factory()->master()->create();
        $admin = User::factory()->admin()->create();

        $this->actingAs($master)->get(route('orders.index'))->assertForbidden();
        $this->actingAs($admin)->get(route('orders.create'))->assertForbidden();
    }

    public function test_master_routes_are_limited_to_masters(): void
    {
        $customer = User::factory()->customer()->create();

        $this->actingAs($customer)->get(route('master.orders.index'))->assertForbidden();
    }

    public function test_filament_order_create_route_is_not_registered(): void
    {
        $this->assertFalse(app('router')->getRoutes()->hasNamedRoute('filament.admin.resources.orders.create'));
    }

    /**
     * @return array{0: ClothingModel, 1: TailoringService, 2: Material, 3?: MeasurementType}
     */
    private function catalog(): array
    {
        $category = ClothingCategory::query()->create([
            'name' => 'Платья',
            'slug' => 'dresses',
            'is_active' => true,
        ]);

        $model = ClothingModel::query()->create([
            'category_id' => $category->id,
            'name' => 'Классическое платье',
            'slug' => 'classic-dress',
            'base_price' => 8000,
            'default_complexity' => ComplexityLevel::Medium,
            'estimated_days' => 10,
            'is_active' => true,
        ]);

        $material = Material::query()->create([
            'name' => 'Шелк',
            'price_modifier' => 500,
            'is_active' => true,
        ]);

        $service = TailoringService::query()->create([
            'name' => 'Пошив изделия с нуля',
            'slug' => 'custom-tailoring',
            'pricing_mode' => ServicePricingMode::ModelBased,
            'base_price' => 6000,
            'model_price_factor' => 1,
            'price_modifier' => 0,
            'requires_model' => true,
            'requires_material' => true,
            'requires_measurements' => true,
            'applies_complexity' => true,
            'applies_urgency' => true,
            'applies_quantity' => true,
            'is_active' => true,
            'sort_order' => 10,
        ]);

        $measurement = MeasurementType::query()->create([
            'name' => 'Рост',
            'slug' => 'height',
            'unit' => 'см',
            'is_active' => true,
            'sort_order' => 10,
        ]);

        $service->measurementTypes()->attach($measurement->id, ['is_required' => true, 'sort_order' => 10]);
        $service->clothingModels()->attach($model->id);

        return [$model, $service, $material, $measurement];
    }
}
