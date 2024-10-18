<?php

namespace App\Services;

use App\Http\Resources\TableResource;
use App\Interfaces\Repositories\TableRepositoryInterface;
use App\Interfaces\Services\TableServiceInterface;
use App\Traits\SortingTraits;
use Illuminate\Support\Facades\Auth;

class TableService implements TableServiceInterface
{
    use SortingTraits;

    private $tableRepository;

    public function __construct(TableRepositoryInterface $tableRepository)
    {
        $this->tableRepository = $tableRepository;
    }

    public function findTables(object $payload)
    {
        $sortField = $this->sortField($payload, 'id');
        $sortOrder = $this->sortOrder($payload, 'asc');

        $user = Auth::user();

        if ($user->getRoleNames()[0] === 'store') {
            $payload->store_id = $user->id;
        } else {
            $payload->store_id = $user->store_id;
        }

        $tables = $this->tableRepository->findMany($payload, $sortField, $sortOrder);

        return TableResource::collection($tables);
    }

    public function findTable(string $uuid)
    {
        $table = $this->tableRepository->findByUuid($uuid);

        return new TableResource($table);
    }

    public function createTable(object $payload)
    {
        $table = $this->tableRepository->create($payload);

        return new TableResource($table);
    }

    public function updateTable(object $payload, string $uuid)
    {
        $table = $this->tableRepository->update($payload, $uuid);

        return new TableResource($table);
    }

    public function deleteTable(string $uuid)
    {
        return $this->tableRepository->delete($uuid);
    }
}
