<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\RunningBillStoreRequest;
use App\Http\Requests\Cashier\RunningBillVoidRequest;
use App\Interfaces\Services\RunningBillServiceInterface;
use Illuminate\Http\Request;

class RunningBillController extends Controller
{
    private $runningBillService;

    public function __construct(RunningBillServiceInterface $runningBillService)
    {
        $this->runningBillService = $runningBillService;
    }

    public function index(Request $request)
    {
        return $this->runningBillService->findBills($request);
    }

    public function store(RunningBillStoreRequest $request)
    {
        return $this->runningBillService->createBill($request);
    }

    public function show(string $uuid)
    {
        return $this->runningBillService->findBill($uuid);
    }

    public function update(RunningBillVoidRequest $request, string $uuid)
    {
        return $this->runningBillService->voidBill($request, $uuid);
    }
}
