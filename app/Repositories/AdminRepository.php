<?php

namespace App\Repositories;

use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Models\Admin;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    public function findMany(object $payload, string $sortField, string $sortOrder)
    {
        return Admin::filter($payload->all())
            ->orderBy($sortField, $sortOrder)
            ->paginate(config('paginate.page'));
    }

    public function findByUsername(string $username)
    {
        return Admin::where('username', $username)->first();
    }

    public function findByUuid(string $uuid)
    {
        return Admin::where('uuid', $uuid)->first();
    }

    public function create(object $payload)
    {
        $admin = new Admin;
        $admin->firstname = $payload->firstname;
        $admin->lastname = $payload->lastname;
        $admin->username = $payload->username;
        $admin->password = Hash::make($payload->password);
        $admin->save();

        $admin->assignRole('admin');

        return $admin->fresh();
    }

    public function update(object $payload, string $uuid)
    {
        $admin = Admin::where('uuid', $uuid)->first();
        $admin->firstname = $payload->firstname;
        $admin->lastname = $payload->lastname;
        $admin->username = $payload->username;
        if ($payload->password) {
            $admin->password = Hash::make($payload->password);
        }
        $admin->is_active = $payload->is_active;
        $admin->save();

        return $admin->fresh();
    }

    public function delete(string $uuid)
    {
        $admin = Admin::where('uuid', $uuid)->first();
        $admin->delete();

        return response()->json([
            'message' => trans('exception.success.message'),
        ], Response::HTTP_OK);
    }
}
