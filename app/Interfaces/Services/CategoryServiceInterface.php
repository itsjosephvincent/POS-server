<?php

namespace App\Interfaces\Services;

interface CategoryServiceInterface
{
    public function findCategories();

    public function findCategory(string $uuid);

    public function createCategory(object $payload);

    public function updateCategory(object $payload, string $uuid);

    public function deleteCategory(string $uuid);
}
