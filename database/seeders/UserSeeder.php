<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Cashier;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'superadmin', 'guard_name' => 'web']);
        Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'store', 'guard_name' => 'web']);
        Role::create(['name' => 'cashier', 'guard_name' => 'web']);

        $superadmin = User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'password' => Hash::make('password'),
        ]);
        $superadmin->assignRole('superadmin');

        $admin = Admin::create([
            'firstname' => 'John',
            'lastname' => 'Doe',
            'username' => 'admin',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole('admin');

        $store = Store::create([
            'admin_id' => $admin->id,
            'store_name' => 'Jollibee',
            'branch' => 'Lanang',
            'username' => 'store',
            'password' => Hash::make('password'),
        ]);
        $store->assignRole('store');

        $cashier = Cashier::create([
            'store_id' => $store->id,
            'name' => 'Jane Doe',
            'username' => 'cashier',
            'password' => Hash::make('password'),
        ]);
        $cashier->assignRole('cashier');
    }
}
