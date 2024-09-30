<?php

namespace App\Interfaces\Services;

interface AuthServiceInterface
{
    public function authenticateSuperadmin(object $payload);

    public function authenticateAdmin(object $payload);

    public function authenticateStore(object $payload);

    public function authenticateCashier(object $payload);

    public function unauthenticate(object $payload);
}
