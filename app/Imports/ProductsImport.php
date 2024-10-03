<?php

namespace App\Imports;

use App\Exceptions\InvalidCategoryException;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
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
                    throw new InvalidCategoryException(trans('exception.invalid_category.message'), Response::HTTP_BAD_REQUEST);
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
        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
