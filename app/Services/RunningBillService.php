<?php

namespace App\Services;

use App\Http\Resources\RunningBillResource;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\RunningBillRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Repositories\TableRepositoryInterface;
use App\Interfaces\Services\RunningBillServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RunningBillService implements RunningBillServiceInterface
{
    use SortingTraits;

    private $runningBillRepository;

    private $storeRepository;

    private $tableRepository;

    private $productRepository;

    public function __construct(
        RunningBillRepositoryInterface $runningBillRepository,
        StoreRepositoryInterface $storeRepository,
        TableRepositoryInterface $tableRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->runningBillRepository = $runningBillRepository;
        $this->storeRepository = $storeRepository;
        $this->tableRepository = $tableRepository;
        $this->productRepository = $productRepository;
    }

    public function findBills(object $payload)
    {
        $sortField = $this->sortField($payload, 'created_at');
        $sortOrder = $this->sortOrder($payload, 'desc');

        $bills = $this->runningBillRepository->findMany($payload, $sortField, $sortOrder);

        return RunningBillResource::collection($bills);
    }

    public function findBill(string $uuid)
    {
        $bill = $this->runningBillRepository->findByUuid($uuid);

        return new RunningBillResource($bill);
    }

    public function createBill(object $payload)
    {
        $table = $this->tableRepository->findByUuid($payload->table_uuid);
        $product = $this->productRepository->findByUuid($payload->product_uuid);

        if ($product->inventory < $payload->quantity) {
            return response()->json([
                'message' => trans('exception.not_enough_inventory.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $payload->table_id = $table->id;
        $payload->product_id = $product->id;
        $bill = $this->runningBillRepository->create($payload);

        $inventoryUpdatePayload = (object) [
            'inventory' => $product->inventory - $payload->quantity,
        ];

        $this->productRepository->updateInventory($inventoryUpdatePayload, $product->id);

        return new RunningBillResource($bill);
    }

    public function voidBill(object $payload, string $uuid)
    {
        $user = Auth::user();

        $store = $this->storeRepository->findById($user->store_id);

        if (! Hash::check($payload->password, $store->password)) {
            return response()->json([
                'message' => trans('exception.invalid_password.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $bill = $this->runningBillRepository->void($uuid);

        $product = $this->productRepository->findById($bill->product_id);

        $inventoryUpdatePayload = (object) [
            'inventory' => $product->inventory + $bill->quantity,
        ];

        $this->productRepository->updateInventory($inventoryUpdatePayload, $bill->product_id);

        return new RunningBillResource($bill);
    }
}
