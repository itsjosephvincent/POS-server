<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function findMany()
    {
        $user = Auth::user();

        return Category::where('admin_id', $user->id)
            ->get();
    }

    public function findByUuid(string $uuid)
    {
        return Category::where('uuid', $uuid)->first();
    }

    public function create(object $payload)
    {
        $user = Auth::user();

        $category = new Category;
        $category->admin_id = $user->id;
        $category->name = $payload->name;
        $category->save();

        return $category->fresh();
    }

    public function update(object $payload, string $uuid)
    {
        $category = Category::where('uuid', $uuid)->first();
        $category->name = $payload->name;
        $category->save();

        return $category->fresh();
    }

    public function delete(string $uuid)
    {
        $category = Category::where('uuid', $uuid)->first();
        $category->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
