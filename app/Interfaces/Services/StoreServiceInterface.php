<?php

namespace App\Interfaces\Services;

interface StoreServiceInterface
{
    public function findStores(object $payload);

    public function findStore(string $uuid);

    public function createStore(object $payload);

    public function updateStore(object $payload, string $uuid);

    public function deleteStore(string $uuid);
}
