<?php

namespace App\Interfaces\Services;

interface CashierServiceInterface
{
    public function findCashiers(object $payload);

    public function findCashier(string $uuid);

    public function createCashier(object $payload);

    public function updateCashier(object $payload, string $uuid);

    public function deleteCashier(string $uuid);
}
