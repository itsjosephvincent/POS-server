<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\OrderDetailServiceInterface;
use Illuminate\Http\Request;

class OrderDetailController extends Controller
{
    private $orderDetailService;

    public function __construct(OrderDetailServiceInterface $orderDetailService)
    {
        $this->orderDetailService = $orderDetailService;
    }

    public function index(Request $request)
    {
        return $this->orderDetailService->findOrderDetails($request);
    }

    public function show(string $uuid)
    {
        return $this->orderDetailService->findOrderDetail($uuid);
    }
}
