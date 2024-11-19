<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\Services\OrdersReportServiceInterface;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $ordersReportService;
    private $orderService;

    public function __construct(
        OrdersReportServiceInterface $ordersReportService,
        OrderService $orderService,
    )
    {
        $this->ordersReportService = $ordersReportService;
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        return $this->ordersReportService->findMany($request);
    }

    public function show(string $uuid)
    {
        return $this->orderService->findOrder($uuid);
    }
}
