<?php

namespace App\Interfaces\Services;

interface OrderServiceInterface
{
    public function findOrders(object $payload);

    public function findOrder(string $uuid);

    public function createOrder(object $payload);
}
