<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BusinessRepositoryInterface;
use App\Models\Business;

class BusinessRepository implements BusinessRepositoryInterface
{
    public function index()
    {
        return Business::all();
    }
    public function show(int $id)
    {
        return Business::findOrFail($id);
    }
    public function create(array $data)
    {
        return Business::create($data);
    }
    public function update(int $id, array $data)
    {
        $business = Business::findOrFail($id);
        $business->update($data);
        return $business;
    }
    public function delete(int $id)
    {
        $business = Business::findOrFail($id);
        // Use soft delete
        // $user->delete();
    }
}