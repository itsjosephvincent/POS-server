<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Support\Facades\Auth;

class CategoryService implements CategoryServiceInterface
{
    use SortingTraits;

    private $categoryRepository;

    private $adminRepository;

    private $storeRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        AdminRepositoryInterface $adminRepository,
        StoreRepositoryInterface $storeRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->adminRepository = $adminRepository;
        $this->storeRepository = $storeRepository;
    }

    public function findCategories()
    {
        $user = Auth::user();

        if ($user->getRoleNames()[0] === 'admin') {
            $adminId = $user->id;
        } elseif ($user->getRoleNames()[0] === 'store') {
            $adminId = $user->admin_id;
        } else {
            $store = $this->storeRepository->findById($user->store_id);
            $admin = $this->adminRepository->findById($store->admin_id);
            $adminId = $admin->id;
        }

        $categories = $this->categoryRepository->findMany($adminId);

        return CategoryResource::collection($categories);
    }

    public function findCategory(string $uuid)
    {
        $category = $this->categoryRepository->findByUuid($uuid);

        return new CategoryResource($category);
    }

    public function createCategory(object $payload)
    {
        $category = $this->categoryRepository->create($payload);

        return new CategoryResource($category);
    }

    public function updateCategory(object $payload, string $uuid)
    {
        $category = $this->categoryRepository->update($payload, $uuid);

        return new CategoryResource($category);
    }

    public function deleteCategory(string $uuid)
    {
        return $this->categoryRepository->delete($uuid);
    }
}
