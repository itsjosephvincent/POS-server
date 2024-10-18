<?php

namespace App\Interfaces\Repositories;

interface OrderRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder);

    public function findByUuid(string $uuid);

    public function create();
}
