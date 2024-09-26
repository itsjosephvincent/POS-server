<?php

namespace App\Repositories;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function index()
    {
        return User::all();
    }

    public function save(object $payload)
    {
        $user = new User();
        $user->role_id = $payload->role_id;
        $user->username = $payload->username;
        $user->password = Hash::make($payload->password);
        $user->name = $payload->name;
        $user->save();

        return $user->fresh();
    }

    public function show(int $id)
    {
        return User::findOrFail($id);
    }

    public function showByUsername(string $username)
    {
        return User::where('username', $username)->first();
    }

    public function update(object $payload, int $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $payload->role_id;
        $user->username = $payload->username;
        $user->name = $payload->name;
        $user->save();

        return $user->fresh();
    }

    public function delete(int $id){
        return User::findOrFail($id)->delete();
    }
}