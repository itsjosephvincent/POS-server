<?php

namespace App\Http\Controllers\Api\Cashier;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cashier\AuthRequest;
use App\Interfaces\Services\AuthServiceInterface;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthRequest $request)
    {
        return $this->authService->authenticateCashier($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->unauthenticate($request);
    }
}
