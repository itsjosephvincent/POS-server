<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Interfaces\Repositories\CategoryRepositoryInterface;
use App\Interfaces\Services\CategoryServiceInterface;
use App\Traits\SortingTraits;

class CategoryService implements CategoryServiceInterface
{
    use SortingTraits;

    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function findCategories()
    {
        $categories = $this->categoryRepository->findMany();

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
