<?php

namespace Tests\Feature;

use App\Enums\ComplexityLevel;
use App\Enums\OrderStatus;
use App\Enums\UrgencyLevel;
use App\Models\ClothingCategory;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Models\Order;
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
        [$model, $material] = $this->catalog();

        $response = $this->actingAs($customer)->post(route('orders.store'), [
            'clothing_model_id' => $model->id,
            'material_id' => $material->id,
            'quantity' => 2,
            'complexity' => ComplexityLevel::Medium->value,
            'urgency' => UrgencyLevel::Fast->value,
            'measurements' => [
                ['key' => 'Рост', 'value' => '170'],
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
        $this->assertSame('Рост', array_key_first($order->measurements));
        $this->assertSame('Длина', array_key_first($order->parameters));
        $this->assertEquals(25500.0, (float) $order->preliminary_price);
        $this->assertCount(1, $order->referenceImages);
        Storage::disk('public')->assertExists($order->referenceImages->first()->file_path);
    }

    public function test_customer_cannot_view_another_customer_order(): void
    {
        $owner = User::factory()->customer()->create();
        $other = User::factory()->customer()->create();
        [$model, $material] = $this->catalog();

        $order = Order::query()->create([
            'order_number' => 'AT-TEST-00001',
            'customer_id' => $owner->id,
            'clothing_model_id' => $model->id,
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
        [$model, $material] = $this->catalog();

        $assigned = Order::query()->create([
            'order_number' => 'AT-TEST-00002',
            'customer_id' => $customer->id,
            'master_id' => $master->id,
            'clothing_model_id' => $model->id,
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
     * @return array{0: ClothingModel, 1: Material}
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

        return [$model, $material];
    }
}
