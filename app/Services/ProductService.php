<?php

namespace App\Services;

use App\Exceptions\InvalidCategoryException;
use App\Http\Resources\ProductResource;
use App\Imports\ProductsImport;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\SpatieRepositoryInterface;
use App\Interfaces\Services\ProductServiceInterface;
use App\Traits\SortingTraits;
use Exception;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProductService implements ProductServiceInterface
{
    use SortingTraits;

    private $productRepository;

    private $categoryRepository;

    private $spatieRepository;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        SpatieRepositoryInterface $spatieRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->spatieRepository = $spatieRepository;
    }

    public function findProducts(object $payload)
    {
        $sortField = $this->sortField($payload, 'id');
        $sortOrder = $this->sortOrder($payload, 'asc');

        if ($payload->category_uuid) {
            $category = $this->categoryRepository->findByUuid($payload->category_uuid);
            $payload->category_id = $category->id;
        }

        $products = $this->productRepository->findMany($payload, $sortField, $sortOrder);

        return ProductResource::collection($products);
    }

    public function findProduct(string $uuid)
    {
        $product = $this->productRepository->findByUuid($uuid);

        return new ProductResource($product);
    }

    public function createProduct(object $payload)
    {
        $category = $this->categoryRepository->findByUuid($payload->category_uuid);
        $payload->category_id = $category->id;

        $product = $this->productRepository->create($payload);

        if ($payload->image) {
            $product->addMedia($payload->image)->toMediaCollection('products-media');
            $fileUrl = $product->getMedia('products-media')->last()->getUrl();
            $product->image = $fileUrl;
            $product->save();
        }

        return new ProductResource($product);
    }

    public function updateProduct(object $payload, string $uuid)
    {
        $product = $this->productRepository->update($payload, $uuid);
        if ($payload->image) {
            $spatiePayload = (object) [
                'model_type' => get_class($product),
                'model_id' => $product->id,
            ];

            $this->spatieRepository->delete($spatiePayload);

            $product->addMedia($payload->image)->toMediaCollection('products-media');
            $fileUrl = $product->getMedia('products-media')->last()->getUrl();
            $product->image = $fileUrl;
            $product->save();
        }

        return new ProductResource($product);
    }

    public function deleteProduct(string $uuid)
    {
        return $this->productRepository->delete($uuid);
    }

    public function importProduct(object $payload)
    {
        try {
            Excel::import(new ProductsImport, $payload->file);

            return response()->json([
                'message' => trans('exception.success.message'),
            ], Response::HTTP_OK);
        } catch (InvalidCategoryException $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            return response()->json([
                'message' => trans('exception.transaction_failed.message'),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
