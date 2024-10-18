<?php

namespace App\Repositories;

use App\Interfaces\Repositories\TableRepositoryInterface;
use App\Models\Table;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TableRepository implements TableRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return Table::where('store_id', $payload->store_id)
            ->filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->get();
    }

    public function findByUuid(string $uuid)
    {
        return Table::with([
            'runningBills',
        ])
            ->where('uuid', $uuid)
            ->first();
    }

    public function create(object $payload)
    {
        $user = Auth::user();

        $table = new Table;
        $table->store_id = $user->id;
        $table->name = $payload->name;
        $table->save();

        return $table->fresh();
    }

    public function update(object $payload, string $uuid)
    {
        $table = Table::where('uuid', $uuid)->first();
        $table->name = $payload->name;
        $table->save();

        return $table->fresh();
    }

    public function delete(string $uuid)
    {
        $table = Table::where('uuid', $uuid)->first();
        $table->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
