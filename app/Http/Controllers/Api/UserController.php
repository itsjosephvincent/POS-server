<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function __construct(
        protected UserService $service,
    ) {}

    public function login(LoginRequest $request)
    {
        $user = $this->service->showByUsername($request->username);
        if (!$user) {
            return response()->json([
                'data' => [
                    'message' => 'Username not found.'
                ]
            ], 401);
        }
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'data' => [
                    'message' => 'Wrong password.'
                ]
            ], 401);
        }
        return response()->json([
            'data' => [
                'token' => $user->createToken($request->userAgent())->plainTextToken
            ]
        ]);
    }

    public function current_user(Request $request)
    {
        return $this->service->show($request->user()->id);
    }

    public function index()
    {
        return $this->service->index();
    }

    public function show(string $id)
    {
        return $this->service->show($id);
    }

    // @TODO - Check out laravel Validation - Form Requests
    public function update(Request $user) {}

    public function destroy(int $id)
    {
        $status = $this->service->delete($id) ? 204 : 404;
        return response()->json([], $status);
    }
}
