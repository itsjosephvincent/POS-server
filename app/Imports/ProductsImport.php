<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    /**
     * @param  Collection  $collection
     */
    public function collection(Collection $rows)
    {
        $user = Auth::user();

        DB::beginTransaction();
        try {
            foreach ($rows as $row) {
                $category = Category::where('admin_id', $user->id)
                    ->where('name', $row['category'])
                    ->first();

                if (! $category) {
                    DB::rollBack();

                    return response()->json([
                        'message' => trans('exception.invalid_category.message'),
                    ], Response::HTTP_BAD_REQUEST);
                }

                $product = new Product;
                $product->category_id = $category->id;
                $product->name = $row['name'];
                $product->cost = $row['cost'];
                $product->price = $row['price'];
                $product->inventory = $row['inventory'];
                $product->save();
            }

            DB::commit();

            return response()->json([
                'message' => trans('exception.success.message'),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => trans('exception.transaction_failed.message'),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
