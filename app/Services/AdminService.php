<?php

namespace App\Services;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Http\Resources\UserResource;

class AdminService
{
    private AdminRepositoryInterface $repository;

    public function __construct(AdminRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return UserResource::collection($this->repository->index());
    }

    public function save(object $data)
    {
        return new UserResource($this->repository->save($data));
    }

    public function show(int $id)
    {
        return $this->repository->show($id);
    }
}
