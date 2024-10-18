<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Interfaces\Repositories\OrderDetailRepositoryInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Interfaces\Repositories\RunningBillRepositoryInterface;
use App\Interfaces\Repositories\TableRepositoryInterface;
use App\Interfaces\Services\OrderServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    use SortingTraits;

    private $orderRepository;

    private $tableRepository;

    private $orderDetailRepository;

    private $runningBillRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        TableRepositoryInterface $tableRepository,
        OrderDetailRepositoryInterface $orderDetailRepository,
        RunningBillRepositoryInterface $runningBillRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->tableRepository = $tableRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->runningBillRepository = $runningBillRepository;
    }

    public function findOrders(object $payload)
    {
        $sortField = $this->sortField($payload, 'created_at');
        $sortOrder = $this->sortOrder($payload, 'desc');

        $orders = $this->orderRepository->findMany($payload, $sortField, $sortOrder);

        return OrderResource::collection($orders);
    }

    public function findOrder(string $uuid)
    {
        $order = $this->orderRepository->findByUuid($uuid);

        return new OrderResource($order);
    }

    public function createOrder(object $payload)
    {
        try {
            DB::beginTransaction();
            $order = $this->orderRepository->create();

            if ($payload->table_uuid) {
                $table = $this->tableRepository->findByUuid($payload->table_uuid);

                if ($table && $table->runningBills->isNotEmpty()) {
                    foreach ($table->runningBills as $bill) {
                        if (! $bill->is_voided) {
                            $orderDetailsPayload = (object) [
                                'order_id' => $order->id,
                                'product_id' => $bill->product_id,
                                'quantity' => $bill->quantity,
                                'price' => $bill->price,
                            ];

                            $this->orderDetailRepository->create($orderDetailsPayload);
                        }
                    }

                    $this->runningBillRepository->delete($table->id);
                }
            }

            if ($payload->cart_uuid) {
            }

            $order = $this->orderRepository->findByUuid($order->uuid);
            DB::commit();

            return new OrderResource($order);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
