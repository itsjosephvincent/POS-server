<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductRepository implements ProductRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return Product::with('category')->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->paginate(config('paginate.page'))
            ;
    }

    public function findByUuid(string $uuid)
    {
        return Product::where('uuid', $uuid)->first();
    }

    public function create(object $payload)
    {
        $product = new Product;
        $product->category_id = $payload->category_id;
        $product->name = $payload->name;
        $product->image = $payload->image ?? null;
        $product->cost = $payload->cost;
        $product->price = $payload->price;
        $product->inventory = $payload->inventory;
        $product->save();

        return $product->fresh();
    }

    public function update(object $payload, string $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();
        $product->name = $payload->name;
        $product->image = $payload->image ?? null;
        $product->cost = $payload->cost;
        $product->price = $payload->price;
        $product->inventory = $payload->inventory;
        $product->save();

        return $product->fresh();
    }

    public function delete(string $uuid)
    {
        $product = Product::where('uuid', $uuid)->first();
        $product->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
