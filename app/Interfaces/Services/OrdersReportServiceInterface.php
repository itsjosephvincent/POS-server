<?php

namespace App\Interfaces\Services;

interface OrdersReportServiceInterface
{
    public function findMany(object $payload);
}