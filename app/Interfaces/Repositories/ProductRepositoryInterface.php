<?php

namespace App\Interfaces\Repositories;

interface ProductRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder);

    public function findByUuid(string $uuid);

    public function findById(int $id);

    public function create(object $payload);

    public function update(object $payload, string $uuid);

    public function updateInventory(object $payload, int $id);

    public function delete(string $uuid);
}
