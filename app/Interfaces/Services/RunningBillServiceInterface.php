<?php

namespace App\Interfaces\Services;

interface RunningBillServiceInterface
{
    public function findBills(object $payload);

    public function findBill(string $uuid);

    public function createBill(object $payload);

    public function voidBill(object $payload, string $uuid);
}
