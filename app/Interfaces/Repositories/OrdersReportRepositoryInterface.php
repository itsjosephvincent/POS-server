<?php

namespace App\Interfaces\Repositories;

interface OrdersReportRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder);
}
