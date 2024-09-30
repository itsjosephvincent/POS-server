<?php

namespace App\Services;

use App\Http\Resources\AdminResource;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Services\AdminServiceInterface;
use App\Traits\SortingTraits;

class AdminService implements AdminServiceInterface
{
    use SortingTraits;

    private $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function findAdmins(object $payload)
    {
        $sortField = $this->sortField($payload, 'id');
        $sortOrder = $this->sortOrder($payload, 'ascend');

        $admins = $this->adminRepository->findMany($payload, $sortField, $sortOrder);

        return AdminResource::collection($admins);
    }

    public function findAdmin(string $uuid)
    {
        $admin = $this->adminRepository->findByUuid($uuid);

        return new AdminResource($admin);
    }

    public function createAdmin(object $payload)
    {
        $admin = $this->adminRepository->create($payload);

        return new AdminResource($admin);
    }

    public function updateAdmin(object $payload, string $uuid)
    {
        $admin = $this->adminRepository->update($payload, $uuid);

        return new AdminResource($admin);
    }

    public function deleteAdmin(string $uuid)
    {
        return $this->adminRepository->delete($uuid);
    }
}
