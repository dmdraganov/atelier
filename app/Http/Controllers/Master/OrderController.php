<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderController extends Controller
{
    public function index()
    {
        $orders = request()->user()
            ->assignedOrders()
            ->with(['customer', 'clothingModel', 'material'])
            ->latest()
            ->paginate(10);

        return view('master.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('master.orders.show', [
            'order' => $order->load(['customer', 'clothingModel.category', 'material', 'referenceImages']),
        ]);
    }
}
