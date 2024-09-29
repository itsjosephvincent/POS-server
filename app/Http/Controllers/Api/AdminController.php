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
        return response()->json([
            'data' => [
                'admins' => $this->service->index(),
            ]
        ]);
    }

    public function store(Request $request)
    {
        try{
            $data = $this->service->save($request);
            return $data;
        }
        catch (\Exception $error)
        {
            return response()->json([
                'error' => 'Error saving data.'
            ], 500);
        }

    }

    public function show(Request $request)
    {
        return $this->service->show($request->user()->id);
    }
}
