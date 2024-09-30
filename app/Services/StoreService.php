<?php

namespace App\Services;

use App\Http\Resources\StoreResource;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Services\StoreServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Support\Facades\Auth;

class StoreService implements StoreServiceInterface
{
    use SortingTraits;

    private $storeRepository;

    private $adminRepository;

    public function __construct(
        StoreRepositoryInterface $storeRepository,
        AdminRepositoryInterface $adminRepository
    ) {
        $this->storeRepository = $storeRepository;
        $this->adminRepository = $adminRepository;
    }

    public function findStores(object $payload)
    {
        $sortField = $this->sortField($payload, 'id');
        $sortOrder = $this->sortOrder($payload, 'asc');

        $stores = $this->storeRepository->findMany($payload, $sortField, $sortOrder);

        return StoreResource::collection($stores);
    }

    public function findStore(string $uuid)
    {
        $store = $this->storeRepository->findByUuid($uuid);

        return new StoreResource($store);
    }

    public function createStore(object $payload)
    {
        $user = Auth::user();

        if ($user->getRoleNames()[0] === 'superadmin') {
            $admin = $this->adminRepository->findByUuid($payload->store_uuid);
            $payload->admin_id = $admin->id;
        }

        if ($user->getRoleNames()[0] === 'admin') {
            $payload->admin_id = $user->id;
        }

        $store = $this->storeRepository->create($payload);

        return new StoreResource($store);
    }

    public function updateStore(object $payload, string $uuid)
    {
        $store = $this->storeRepository->update($payload, $uuid);

        return new StoreResource($store);
    }

    public function deleteStore(string $uuid)
    {
        return $this->storeRepository->delete($uuid);
    }
}
