<?php
namespace App\Interfaces\Repositories;

interface AdminRepositoryInterface
{
    public function index();
    public function save(object $data);
    public function show(int $id);
}
