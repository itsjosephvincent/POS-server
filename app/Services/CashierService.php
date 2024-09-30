<?php

namespace App\Services;

use App\Http\Resources\CashierResource;
use App\Interfaces\Repositories\CashierRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Services\CashierServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Support\Facades\Auth;

class CashierService implements CashierServiceInterface
{
    use SortingTraits;

    private $cashierRepository;

    private $storeRepository;

    public function __construct(
        CashierRepositoryInterface $cashierRepository,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->cashierRepository = $cashierRepository;
        $this->storeRepository = $storeRepository;
    }

    public function findCashiers(object $payload)
    {
        $sortField = $this->sortField($payload, 'id');
        $sortOrder = $this->sortOrder($payload, 'ascend');

        $cashiers = $this->cashierRepository->findMany($payload, $sortField, $sortOrder);

        return CashierResource::collection($cashiers);
    }

    public function findCashier(string $uuid)
    {
        $cashier = $this->cashierRepository->findByUuid($uuid);

        return new CashierResource($cashier);
    }

    public function createCashier(object $payload)
    {
        $user = Auth::user();

        if ($user->getRoleNames()[0] === 'admin' || $user->getRoleNames()[0] === 'superadmin') {
            $store = $this->storeRepository->findByUuid($payload->store_uuid);
            $payload->store_id = $store->id;
        }

        if ($user->getRoleNames()[0] === 'store') {
            $payload->store_id = $user->id;
        }

        $cashier = $this->cashierRepository->create($payload);

        return new CashierResource($cashier);
    }

    public function updateCashier(object $payload, string $uuid)
    {
        $cashier = $this->cashierRepository->update($payload, $uuid);

        return new CashierResource($cashier);
    }

    public function deleteCashier(string $uuid)
    {
        return $this->cashierRepository->delete($uuid);
    }
}
