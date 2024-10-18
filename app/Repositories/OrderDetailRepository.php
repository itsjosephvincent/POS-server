<?php

namespace App\Repositories;

use App\Interfaces\Repositories\OrderDetailRepositoryInterface;
use App\Models\OrderDetail;

class OrderDetailRepository implements OrderDetailRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return OrderDetail::with([
            'order',
            'product',
        ])
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->paginate(config('paginate.page'));
    }

    public function findByUuid(string $uuid)
    {
        return OrderDetail::with([
            'order',
            'product',
        ])
            ->where('uuid', $uuid)
            ->first();
    }

    public function create(object $payload)
    {
        $detail = new OrderDetail;
        $detail->order_id = $payload->order_id;
        $detail->product_id = $payload->product_id;
        $detail->quantity = $payload->quantity;
        $detail->price = $payload->price;
        $detail->save();

        return $detail->fresh();
    }
}
