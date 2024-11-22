<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Http\Response;

class ProductRepository implements ProductRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return Product::with([
            'category',
        ])
            ->whereHas('category', function ($query) use ($payload) {
                $query->where('admin_id', $payload->admin_id);
            })
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->paginate(config('paginate.page'));
    }

    public function findByUuid(string $uuid)
    {
        return Product::with(['category'])->where('uuid', $uuid)->first();
    }

    public function findById(int $id)
    {
        return Product::findOrFail($id);
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
        $product->name = $payload->name ?? $product->name;
        $product->image = $payload->image ? $payload->image : $product->image;
        $product->cost = $payload->cost ?? $product->cost;
        $product->price = $payload->price ?? $product->price;
        $product->inventory = $payload->inventory ?? $product->inventory;
        $product->save();

        return $product->fresh();
    }

    public function updateInventory(object $payload, int $id)
    {
        $product = Product::findOrFail($id);
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
