<?php

namespace App\Interfaces\Services;

interface AdminServiceInterface
{
    public function findAdmins(object $payload);

    public function findAdmin(string $uuid);

    public function createAdmin(object $payload);

    public function updateAdmin(object $payload, string $uuid);

    public function deleteAdmin(string $uuid);
}
