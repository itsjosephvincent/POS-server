<?php

namespace App\Interfaces\Repositories;

interface CartRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder);

    public function findByUuid(string $uuid);

    public function create(object $payload);

    public function void(string $uuid);

    public function delete(int $cashierId);
}
