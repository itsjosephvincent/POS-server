<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CashierStoreRequest;
use App\Http\Requests\Store\CashierUpdateRequest;
use App\Interfaces\Services\CashierServiceInterface;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    private $cashierService;

    public function __construct(CashierServiceInterface $cashierService)
    {
        $this->cashierService = $cashierService;
    }

    public function index(Request $request)
    {
        return $this->cashierService->findCashiers($request);
    }

    public function store(CashierStoreRequest $request)
    {
        return $this->cashierService->createCashier($request);
    }

    public function show(string $uuid)
    {
        return $this->cashierService->findCashier($uuid);
    }

    public function update(CashierUpdateRequest $request, string $uuid)
    {
        return $this->cashierService->updateCashier($request, $uuid);
    }

    public function destroy(string $uuid)
    {
        return $this->cashierService->deleteCashier($uuid);
    }
}
