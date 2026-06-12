<?php

namespace App\Policies;

use App\Enums\OrderStatus;
use App\Enums\UserRole;
use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool
    {
        return in_array($user->role, [UserRole::Customer, UserRole::Master, UserRole::Admin], true);
    }

    public function view(User $user, Order $order): bool
    {
        return $user->role === UserRole::Admin
            || ($user->role === UserRole::Customer && $order->customer_id === $user->id)
            || ($user->role === UserRole::Master && $order->master_id === $user->id);
    }

    public function create(User $user): bool
    {
        return $user->role === UserRole::Customer;
    }

    public function update(User $user, Order $order): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function delete(User $user, Order $order): bool
    {
        return $user->role === UserRole::Admin;
    }

    public function cancel(User $user, Order $order): bool
    {
        return $user->role === UserRole::Customer
            && $order->customer_id === $user->id
            && in_array($order->status, [OrderStatus::New, OrderStatus::Confirmed], true);
    }

    public function restore(User $user, Order $order): bool
    {
        return false;
    }

    public function forceDelete(User $user, Order $order): bool
    {
        return false;
    }
}
