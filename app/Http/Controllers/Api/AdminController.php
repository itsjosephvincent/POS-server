<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admin;
use App\Services\AdminService;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function __construct(
        protected AdminService $service,
    ) {}

    public function index()
    {
        return $this->service->index();
    }

    public function store(Request $request)
    {
        return $this->service->save($request);
    }

    public function show(Request $request)
    {
        return $this->service->show($request->user()->id);
    }
}
