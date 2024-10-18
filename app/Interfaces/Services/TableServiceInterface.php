<?php

namespace App\Interfaces\Services;

interface TableServiceInterface
{
    public function findTables(object $payload);

    public function findTable(string $uuid);

    public function createTable(object $payload);

    public function updateTable(object $payload, string $uuid);

    public function deleteTable(string $uuid);
}
