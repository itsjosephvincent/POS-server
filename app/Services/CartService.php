<?php

namespace App\Services;

use App\Http\Resources\CartResource;
use App\Interfaces\Repositories\CartRepositoryInterface;
use App\Interfaces\Repositories\CashierRepositoryInterface;
use App\Interfaces\Repositories\ProductRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Services\CartServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CartService implements CartServiceInterface
{
    use SortingTraits;

    private $cartRepository;

    private $storeRepository;

    private $cashierRepository;

    private $productRepository;

    public function __construct(
        CartRepositoryInterface $cartRepository,
        StoreRepositoryInterface $storeRepository,
        CashierRepositoryInterface $cashierRepository,
        ProductRepositoryInterface $productRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->storeRepository = $storeRepository;
        $this->cashierRepository = $cashierRepository;
        $this->productRepository = $productRepository;
    }

    public function findCarts(object $payload)
    {
        $sortField = $this->sortField($payload, 'created_at');
        $sortOrder = $this->sortOrder($payload, 'desc');

        $carts = $this->cartRepository->findMany($payload, $sortField, $sortOrder);

        return CartResource::collection($carts);
    }

    public function findCart(string $uuid)
    {
        $cart = $this->cartRepository->findByUuid($uuid);

        return new CartResource($cart);
    }

    public function createCart(object $payload)
    {
        $cashier = $this->cashierRepository->findByUuid($payload->cashier_uuid);
        $product = $this->productRepository->findByUuid($payload->product_uuid);

        if ($product->inventory < $payload->quantity) {
            return response()->json([
                'message' => trans('exception.not_enough_inventory.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $payload->table_id = $cashier->id;
        $payload->product_id = $product->id;
        $cart = $this->cartRepository->create($payload);

        $inventoryUpdatePayload = (object) [
            'inventory' => $product->inventory - $payload->quantity,
        ];

        $this->productRepository->update($inventoryUpdatePayload, $product->uuid);

        return new CartResource($cart);
    }

    public function voidCart(object $payload, string $uuid)
    {
        $user = Auth::user();

        $store = $this->storeRepository->findById($user->store_id);

        if (! Hash::check($payload->password, $store->password)) {
            return response()->json([
                'message' => trans('exception.invalid_password.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $bill = $this->cartRepository->void($uuid);

        return new CartResource($bill);
    }
}
