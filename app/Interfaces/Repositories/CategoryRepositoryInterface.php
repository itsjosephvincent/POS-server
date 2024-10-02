<?php

namespace App\Interfaces\Repositories;

interface CategoryRepositoryInterface
{
    public function findMany();

    public function findByUuid(string $uuid);

    public function create(object $payload);

    public function update(object $payload, string $uuid);

    public function delete(string $uuid);
}
