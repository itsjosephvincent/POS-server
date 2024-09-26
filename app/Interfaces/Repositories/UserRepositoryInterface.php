<?php

namespace App\Interfaces\Repositories;

interface UserRepositoryInterface
{
    public function index();
    public function save(object $data);
    public function show(int $id);
    public function showByUsername(string $username);
    public function update(object $payload, int $id);
    public function delete(int $id);

}