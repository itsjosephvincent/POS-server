<?php

namespace App\Repositories;

use App\Interfaces\Repositories\RunningBillRepositoryInterface;
use App\Models\RunningBill;
use Illuminate\Http\Response;

class RunningBillRepository implements RunningBillRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return RunningBill::with([
            'table',
            'product',
        ])
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->get();
    }

    public function findByUuid(string $uuid)
    {
        return RunningBill::with([
            'table',
            'product',
        ])
            ->where('uuid', $uuid)
            ->first();
    }

    public function create(object $payload)
    {
        $bill = new RunningBill;
        $bill->table_id = $payload->table_id;
        $bill->product_id = $payload->product_id;
        $bill->quantity = $payload->quantity;
        $bill->price = $payload->price;
        $bill->save();

        return $bill->fresh();
    }

    public function void(string $uuid)
    {
        $bill = RunningBill::where('uuid', $uuid)->first();
        $bill->is_voided = true;
        $bill->save();

        return $bill->fresh();
    }

    public function delete(int $tableId)
    {
        RunningBill::where('table_id', $tableId)->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
