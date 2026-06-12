<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use DomainException;

class OrderStatusService
{
    public function canBeCancelledByCustomer(Order $order): bool
    {
        return in_array($order->status, [OrderStatus::New, OrderStatus::Confirmed], true);
    }

    public function cancelByCustomer(Order $order): Order
    {
        if (! $this->canBeCancelledByCustomer($order)) {
            throw new DomainException('Заказ уже передан в производство и не может быть отменен.');
        }

        $order->forceFill([
            'status' => OrderStatus::Cancelled,
            'cancelled_at' => now(),
        ])->save();

        return $order->refresh();
    }
}
