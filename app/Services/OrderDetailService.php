<?php

namespace App\Services;

use App\Http\Resources\OrderDetailResource;
use App\Interfaces\Repositories\OrderDetailRepositoryInterface;
use App\Interfaces\Services\OrderDetailServiceInterface;
use App\Traits\SortingTraits;

class OrderDetailService implements OrderDetailServiceInterface
{
    use SortingTraits;

    private $orderDetailRepository;

    public function __construct(OrderDetailRepositoryInterface $orderDetailRepository)
    {
        $this->orderDetailRepository = $orderDetailRepository;
    }

    public function findOrderDetails(object $payload)
    {
        $sortField = $this->sortField($payload, 'created_at');
        $sortOrder = $this->sortOrder($payload, 'asc');

        $details = $this->orderDetailRepository->findMany($payload, $sortField, $sortOrder);

        return OrderDetailResource::collection($details);
    }

    public function findOrderDetail(string $uuid)
    {
        $detail = $this->orderDetailRepository->findByUuid($uuid);

        return new OrderDetailResource($detail);
    }
}
