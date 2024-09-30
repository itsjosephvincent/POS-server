<?php

namespace App\Repositories;

use App\Interfaces\Repositories\StoreRepositoryInterface;
use App\Models\Store;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class StoreRepository implements StoreRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return Store::where('admin_id', $payload->admin_id)
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->paginate(config('paginate.page'));
    }

    public function findByUsername(string $username)
    {
        return Store::where('username', $username)->first();
    }

    public function findByUuid(string $uuid)
    {
        return Store::where('uuid', $uuid)->first();
    }

    public function create(object $payload)
    {
        $store = new Store;
        $store->admin_id = $payload->admin_id;
        $store->store_name = $payload->store_name;
        $store->branch = $payload->branch ?? null;
        $store->username = $payload->username;
        $store->password = Hash::make($payload->password);
        $store->save();

        $store->assignRole('store');

        return $store->fresh();
    }

    public function update(object $payload, string $uuid)
    {
        $store = Store::where('uuid', $uuid)->first();
        $store->store_name = $payload->store_name;
        $store->branch = $payload->branch ?? null;
        $store->username = $payload->username;
        if ($payload->password) {
            $store->password = Hash::make($payload->password);
        }
        $store->is_active = $payload->is_active;
        $store->save();

        return $store->fresh();
    }

    public function delete(string $uuid)
    {
        $store = Store::where('uuid', $uuid)->first();
        $store->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
