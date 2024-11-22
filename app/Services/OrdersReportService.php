<?php

namespace App\Services;

use App\Interfaces\Repositories\OrdersReportRepositoryInterface;
use App\Interfaces\Services\OrdersReportServiceInterface;
use App\Traits\SortingTraits;

class OrdersReportService implements OrdersReportServiceInterface
{
    use SortingTraits;

    private $ordersReportRepository;

    public function __construct(
        OrdersReportRepositoryInterface $ordersReportRepository,
    ) {
        $this->ordersReportRepository = $ordersReportRepository;
    }

    public function findMany(object $payload)
    {
        $sortField = $this->sortField($payload, 'created_at');
        $sortOrder = $this->sortOrder($payload, 'desc');

        $orders = $this->ordersReportRepository->findMany($payload, $sortField, $sortOrder);

        return $orders;
    }
}
