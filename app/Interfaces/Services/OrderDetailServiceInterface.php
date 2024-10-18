<?php

namespace App\Interfaces\Services;

interface OrderDetailServiceInterface
{
    public function findOrderDetails(object $payload);

    public function findOrderDetail(string $uuid);
}
