<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
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

    public function show(string $uuid)
    {
        return $this->productService->findProduct($uuid);
    }
}
