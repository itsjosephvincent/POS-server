<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStoreRequest;
use App\Http\Requests\Admin\StoreUpdateRequest;
use App\Interfaces\Services\StoreServiceInterface;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private $storeService;

    public function __construct(StoreServiceInterface $storeService)
    {
        $this->storeService = $storeService;
    }

    public function index(Request $request)
    {
        return $this->storeService->findStores($request);
    }

    public function store(StoreStoreRequest $request)
    {
        return $this->storeService->createStore($request);
    }

    public function show(string $uuid)
    {
        return $this->storeService->findStore($uuid);
    }

    public function update(StoreUpdateRequest $request, string $uuid)
    {
        return $this->storeService->updateStore($request, $uuid);
    }

    public function destroy(string $uuid)
    {
        return $this->storeService->deleteStore($uuid);
    }
}
