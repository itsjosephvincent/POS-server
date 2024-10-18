<?php

namespace App\Interfaces\Services;

interface CartServiceInterface
{
    public function findCarts(object $payload);

    public function findCart(string $uuid);

    public function createCart(object $payload);

    public function voidCart(object $payload, string $uuid);
}
