<?php

namespace App\Interfaces\Repositories;

interface SuperadminRepositoryInterface
{
    public function findByUsername(string $username);
}
