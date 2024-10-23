<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderRepository implements OrderRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        $user = Auth::user();

        $query = Order::with([
            'cashier',
            'orderDetails',
        ])
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder);

        if ($user->getRoleNames()[0] === 'Usher') {
            $query->where('cashier_id', $user->id);
        } else {
            $query->whereIn('cashier_id', $payload->cashier_id);
        }

        $orders = $query->paginate(config('paginate.page'));

        return $orders;
    }

    public function findByUuid(string $uuid)
    {
        return Order::with([
            'cashier',
            'orderDetails',
        ])
            ->where('uuid', $uuid)
            ->first();
    }

    public function create(object $payload)
    {
        $user = Auth::user();

        $order = new Order;
        $order->cashier_id = $user->id;
        $order->payment = $payload->payment;
        $order->save();

        return $order->fresh();
    }
}
