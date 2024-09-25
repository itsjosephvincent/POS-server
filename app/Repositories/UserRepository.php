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
        $user->email = $payload->email;
        $user->password = Hash::make($payload->password);
        $user->firstname = $payload->firstname;
        $user->lastname = $payload->lastname;
        $user->save();

        return $user->fresh();
    }

    public function show(int $id)
    {
        return User::findOrFail($id);
    }

    public function showByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function update(object $payload, int $id)
    {
        $user = User::findOrFail($id);
        $user->role_id = $payload->role_id;
        $user->email = $payload->email;
        $user->firstname = $payload->firstname;
        $user->lastname = $payload->lastname;
        $user->save();

        return $user->fresh();
    }

    public function delete(int $id){
        return User::findOrFail($id)->delete();
    }
}