<?php

namespace App\Interfaces\Repositories;

interface OrderDetailRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder);

    public function findByUuid(string $uuid);

    public function create(object $payload);
}
