<?php

namespace App\Http\Controllers\Api\Superadmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Superadmin\AuthRequest;
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
        return $this->authService->authenticateSuperadmin($request);
    }

    public function logout(Request $request)
    {
        return $this->authService->unauthenticate($request);
    }
}
