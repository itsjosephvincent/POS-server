<?php

namespace App\Http\Controllers\Api\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\TableStoreRequest;
use App\Http\Requests\Store\TableUpdateRequest;
use App\Interfaces\Services\TableServiceInterface;
use Illuminate\Http\Request;

class TableController extends Controller
{
    private $tableService;

    public function __construct(TableServiceInterface $tableService)
    {
        $this->tableService = $tableService;
    }

    public function index(Request $request)
    {
        return $this->tableService->findTables($request);
    }

    public function store(TableStoreRequest $request)
    {
        return $this->tableService->createTable($request);
    }

    public function show(string $uuid)
    {
        return $this->tableService->findTable($uuid);
    }

    public function update(TableUpdateRequest $request, string $uuid)
    {
        return $this->tableService->updateTable($request, $uuid);
    }

    public function destroy(string $uuid)
    {
        return $this->tableService->deleteTable($uuid);
    }
}
