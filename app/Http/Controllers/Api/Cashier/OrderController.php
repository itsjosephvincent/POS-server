<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\OrderStoreRequest;
use App\Interfaces\Services\OrderServiceInterface;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $orderService;

    public function __construct(OrderServiceInterface $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        return $this->orderService->findOrders($request);
    }

    public function store(OrderStoreRequest $request)
    {
        return $this->orderService->createOrder($request);
    }

    public function show(string $uuid)
    {
        return $this->orderService->findOrder($uuid);
    }
}
