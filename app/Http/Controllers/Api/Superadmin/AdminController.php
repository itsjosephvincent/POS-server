<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\AdminStoreRequest;
use App\Http\Requests\Superadmin\AdminUpdateRequest;
use App\Interfaces\Services\AdminServiceInterface;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    private $adminService;

    public function __construct(AdminServiceInterface $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index(Request $request)
    {
        return $this->adminService->findAdmins($request);
    }

    public function store(AdminStoreRequest $request)
    {
        return $this->adminService->createAdmin($request);
    }

    public function show(string $uuid)
    {
        return $this->adminService->findAdmin($uuid);
    }

    public function update(AdminUpdateRequest $request, string $uuid)
    {
        return $this->adminService->updateAdmin($request, $uuid);
    }

    public function destroy(string $uuid)
    {
        return $this->adminService->deleteAdmin($uuid);
    }
}
