<?php

namespace App\Interfaces\Repositories;

interface CashierRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder);

    public function findByUsername(string $username);

    public function findByUuid(string $uuid);

    public function create(object $payload);

    public function update(object $payload, string $uuid);

    public function delete(string $uuid);
}
