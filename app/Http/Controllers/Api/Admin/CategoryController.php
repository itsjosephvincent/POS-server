<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Interfaces\Services\CategoryServiceInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        return $this->categoryService->findCategories($request);
    }

    public function store(CategoryStoreRequest $request)
    {
        return $this->categoryService->createCategory($request);
    }

    public function show(string $uuid)
    {
        return $this->categoryService->findCategory($uuid);
    }

    public function update(CategoryUpdateRequest $request, string $uuid)
    {
        return $this->categoryService->updateCategory($request, $uuid);
    }

    public function destroy(string $uuid)
    {
        return $this->categoryService->deleteCategory($uuid);
    }
}
