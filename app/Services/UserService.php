<?php

namespace App\Services;
use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Http\Resources\UserResource;

class UserService
{
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository)
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
        return new UserResource($this->repository->show($id));
    }

    public function showByUsername(string $username)
    {
        return new UserResource($this->repository->showByUsername($username));
    }

    public function update(object $payload, int $id)
    {
        return new UserResource($this->repository->update($payload, $id));
    }

    public function delete(int $id)
    {
        return new UserResource($this->repository->delete($id));
    }
}