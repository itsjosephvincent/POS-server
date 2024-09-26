<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function __construct(
        protected UserService $service,
    ) {}

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = $this->service->showByUsername($request->username);
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'data' => [
                'token'=>$user->createToken($request->userAgent())->plainTextToken
            ]
        ]);
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
    public function update(Request $user)
    {

    }

}
