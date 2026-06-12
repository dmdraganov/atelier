<?php

namespace App\Http\Controllers;

use App\Enums\ComplexityLevel;
use App\Enums\UrgencyLevel;
use App\Http\Requests\StoreOrderRequest;
use App\Models\ClothingModel;
use App\Models\Material;
use App\Models\Order;
use App\Services\OrderCreationService;
use App\Services\OrderStatusService;
use DomainException;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    public function index()
    {
        $orders = request()->user()
            ->customerOrders()
            ->with(['clothingModel', 'material'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $models = ClothingModel::query()
            ->where('is_active', true)
            ->with('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $materials = Material::query()
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('orders.create', [
            'models' => $models,
            'materials' => $materials,
            'complexities' => ComplexityLevel::cases(),
            'urgencies' => UrgencyLevel::cases(),
        ]);
    }

    public function store(StoreOrderRequest $request, OrderCreationService $service): RedirectResponse
    {
        $order = $service->create($request->user(), $request->validated());

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Заказ создан. Предварительная стоимость рассчитана.');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('orders.show', [
            'order' => $order->load(['clothingModel.category', 'material', 'referenceImages', 'master']),
        ]);
    }

    public function cancel(Order $order, OrderStatusService $service): RedirectResponse
    {
        $this->authorize('cancel', $order);

        try {
            $service->cancelByCustomer($order);
        } catch (DomainException $exception) {
            return back()->withErrors(['order' => $exception->getMessage()]);
        }

        return redirect()
            ->route('orders.show', $order)
            ->with('status', 'Заказ отменен.');
    }
}
