<?php

namespace App\Repositories;

use App\Interfaces\Repositories\CashierRepositoryInterface;
use App\Models\Cashier;
use Illuminate\Http\Response;

class CashierRepository implements CashierRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return Cashier::where('store_id', $payload->store_id)
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->paginate(config('paginate.page'));
    }

    public function findByUsername(string $username)
    {
        return Cashier::where('username', $username)->first();
    }

    public function findByUuid(string $uuid)
    {
        return Cashier::where('uuid', $uuid)->first();
    }

    public function create(object $payload)
    {
        $cashier = new Cashier;
        $cashier->store_id = $payload->store_id;
        $cashier->name = $payload->name;
        $cashier->username = $payload->username;
        $cashier->password = $payload->password;
        $cashier->save();

        return $cashier->fresh();
    }

    public function update(object $payload, string $uuid)
    {
        $cashier = Cashier::where('uuid', $uuid)->first();
        $cashier->name = $payload->name;
        $cashier->username = $payload->username;
        if ($payload->password) {
            $cashier->password = $payload->password;
        }
        $cashier->is_active = $payload->is_active;
        $cashier->save();

        return $cashier->fresh();
    }

    public function delete(string $uuid)
    {
        $cashier = Cashier::where('uuid', $uuid)->first();
        $cashier->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
