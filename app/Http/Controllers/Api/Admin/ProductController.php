<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Interfaces\Services\ProductServiceInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(ProductServiceInterface $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        return $this->productService->findProducts($request);
    }

    public function store(ProductStoreRequest $request)
    {
        return $this->productService->createProduct($request);
    }

    public function show(string $uuid)
    {
        return $this->productService->findProduct($uuid);
    }

    public function update(ProductUpdateRequest $request, string $uuid)
    {
        return $this->productService->updateProduct($request, $uuid);
    }

    public function destroy(string $uuid)
    {
        return $this->productService->deleteProduct($uuid);
    }
}
