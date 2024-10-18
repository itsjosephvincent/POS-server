<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\CartStoreRequest;
use App\Http\Requests\Cashier\CartVoidRequest;
use App\Interfaces\Services\CartServiceInterface;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartServiceInterface $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        return $this->cartService->findCarts($request);
    }

    public function store(CartStoreRequest $request)
    {
        return $this->cartService->createCart($request);
    }

    public function show(string $uuid)
    {
        return $this->cartService->findCart($uuid);
    }

    public function update(CartVoidRequest $request, string $uuid)
    {
        return $this->cartService->voidCart($request, $uuid);
    }
}
