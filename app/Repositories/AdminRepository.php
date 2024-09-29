<?php

namespace App\Repositories;

use App\Http\Resources\AdminResource;
use App\Interfaces\Repositories\AdminRepositoryInterface;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface
{
    public function index()
    {
        // echo json_encode(Admin::with('user')->get());
        return Admin::with('user')->paginate(5);
    }
    public function save(object $data)
    {
        $user = new User();
        $user->username = $data->username;
        $user->name = $data->name;
        $user->password = Hash::make($data->password);
        $user->save();
        $user->assignRole('Admin');

        // $freshUser = $user->fresh();

        $admin = new Admin();
        $admin->user_id = $user->id;
        $admin->business_name = $data->business_name;
        $admin->save();

        return $user->fresh();
    }

    public function show(int $id)
    {
        $admin = Admin::with('user')->where('user_id', $id)->firstOrFail();
        // $user = $admin->user();

        return new AdminResource($admin);
    }
}
