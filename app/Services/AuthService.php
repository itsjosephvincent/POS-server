<?php

namespace App\Services;

use App\Http\Resources\AdminResource;
use App\Http\Resources\AuthResource;
use App\Http\Resources\CashierResource;
use App\Http\Resources\StoreResource;
use App\Http\Resources\SuperadminResource;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Interfaces\Repositories\CashierRepositoryInterface;
use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Interfaces\Repositories\SuperadminRepositoryInterface;
use App\Interfaces\Services\AuthServiceInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthServiceInterface
{
    private $superadminRepository;

    private $adminRepository;

    private $storeRepository;

    private $cashierRepository;

    public function __construct(
        SuperadminRepositoryInterface $superadminRepository,
        AdminRepositoryInterface $adminRepository,
        StoreRepositoryInterface $storeRepository,
        CashierRepositoryInterface $cashierRepository,
    ) {
        $this->superadminRepository = $superadminRepository;
        $this->adminRepository = $adminRepository;
        $this->storeRepository = $storeRepository;
        $this->cashierRepository = $cashierRepository;
    }

    public function authenticateSuperadmin(object $payload)
    {
        $superadmin = $this->superadminRepository->findByUsername($payload->username);

        if (! $superadmin) {
            return response()->json([
                'message' => trans('exception.invalid_username.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        if (! Hash::check($payload->password, $superadmin->password)) {
            return response()->json([
                'message' => trans('exception.invalid_password.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = (object) [
            'token' => $superadmin->createToken('auth-token')->plainTextToken,
            'user' => new SuperadminResource($superadmin),
        ];

        return new AuthResource($data);
    }

    public function authenticateAdmin(object $payload)
    {
        $admin = $this->adminRepository->findByUsername($payload->username);

        if (! $admin) {
            return response()->json([
                'message' => trans('exception.invalid_username.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        if (! Hash::check($payload->password, $admin->password)) {
            return response()->json([
                'message' => trans('exception.invalid_password.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = (object) [
            'token' => $admin->createToken('auth-token')->plainTextToken,
            'user' => new AdminResource($admin),
        ];

        return new AuthResource($data);
    }

    public function authenticateStore(object $payload)
    {
        $store = $this->storeRepository->findByUsername($payload->username);

        if (! $store) {
            return response()->json([
                'message' => trans('exception.invalid_username.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        if (! Hash::check($payload->password, $store->password)) {
            return response()->json([
                'message' => trans('exception.invalid_password.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = (object) [
            'token' => $store->createToken('auth-token')->plainTextToken,
            'user' => new StoreResource($store),
        ];

        return new AuthResource($data);
    }

    public function authenticateCashier(object $payload)
    {
        $cashier = $this->cashierRepository->findByUsername($payload->username);

        if (! $cashier) {
            return response()->json([
                'message' => trans('exception.invalid_username.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        if (! Hash::check($payload->password, $cashier->password)) {
            return response()->json([
                'message' => trans('exception.invalid_password.message'),
            ], Response::HTTP_BAD_REQUEST);
        }

        $data = (object) [
            'token' => $cashier->createToken('auth-token')->plainTextToken,
            'user' => new CashierResource($cashier),
        ];

        return new AuthResource($data);
    }

    public function unauthenticate(object $payload)
    {
        $payload->user()->tokens()->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
