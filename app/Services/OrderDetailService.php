<?php

namespace App\Services;

use App\Interfaces\Repositories\OrderDetailRepositoryInterface;
use App\Interfaces\Services\OrderDetailServiceInterface;

class OrderDetailService implements OrderDetailServiceInterface
{
    private $orderDetailRepository;

    public function __construct(OrderDetailRepositoryInterface $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function findOrderDetails(object $payload)
    {
        //
    }

    public function findOrderDetail(string $uuid)
    {
        //
    }
}
