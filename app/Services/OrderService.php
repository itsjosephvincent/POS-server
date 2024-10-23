<?php

namespace App\Services;

use App\Http\Resources\OrderResource;
use App\Interfaces\Repositories\CartRepositoryInterface;
use App\Interfaces\Repositories\CashierRepositoryInterface;
use App\Interfaces\Repositories\OrderDetailRepositoryInterface;
use App\Interfaces\Repositories\OrderRepositoryInterface;
use App\Interfaces\Repositories\RunningBillRepositoryInterface;
use App\Interfaces\Repositories\TableRepositoryInterface;
use App\Interfaces\Services\OrderServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService implements OrderServiceInterface
{
    use SortingTraits;

    private $orderRepository;

    private $tableRepository;

    private $orderDetailRepository;

    private $runningBillRepository;

    private $cashierRepository;

    private $cartRepository;

    public function __construct(
        OrderRepositoryInterface $orderRepository,
        TableRepositoryInterface $tableRepository,
        OrderDetailRepositoryInterface $orderDetailRepository,
        RunningBillRepositoryInterface $runningBillRepository,
        CashierRepositoryInterface $cashierRepository,
        CartRepositoryInterface $cartRepository
    ) {
        $this->orderRepository = $orderRepository;
        $this->tableRepository = $tableRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->runningBillRepository = $runningBillRepository;
        $this->cashierRepository = $cashierRepository;
        $this->cartRepository = $cartRepository;
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

            $user = Auth::user();

            $order = $this->orderRepository->create($payload);

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
            } else {
                $cashier = $this->cashierRepository->findByUuid($user->uuid);

                if ($cashier && $cashier->carts->isNotEmpty()) {
                    foreach ($cashier->carts as $cart) {
                        if (! $cart->is_voided) {
                            $orderDetailsPayload = (object) [
                                'order_id' => $order->id,
                                'product_id' => $cart->product_id,
                                'quantity' => $cart->quantity,
                                'price' => $cart->price,
                            ];

                            $this->orderDetailRepository->create($orderDetailsPayload);
                        }
                    }

                    $this->cartRepository->delete($cashier->id);
                }
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
