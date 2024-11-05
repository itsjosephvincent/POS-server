<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CartRepositoryInterface;
use App\Models\Cart;
use Illuminate\Http\Response;

class CartRepository implements CartRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return Cart::with([
            'cashier',
            'product',
        ])
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->get();
    }

    public function findByUuid(string $uuid)
    {
        return Cart::with([
            'cashier',
            'product',
        ])
            ->where('uuid', $uuid)
            ->first();
    }

    public function create(object $payload)
    {
        $bill = new Cart;
        $bill->cashier_id = $payload->cashier_id;
        $bill->product_id = $payload->product_id;
        $bill->quantity = $payload->quantity;
        $bill->price = $payload->price;
        $bill->save();

        return $bill->fresh();
    }

    public function delete(string $uuid)
    {
        $bill = Cart::where('uuid', $uuid)->first();
        $bill->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }

    public function deleteAll(int $cashierId)
    {
        Cart::where('cashier_id', $cashierId)->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
