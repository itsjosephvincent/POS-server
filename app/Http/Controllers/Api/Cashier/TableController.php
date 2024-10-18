<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
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

    public function show(string $uuid)
    {
        return $this->tableService->findTable($uuid);
    }
}
