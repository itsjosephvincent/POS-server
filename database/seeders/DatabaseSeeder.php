<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::create(['name' => 'SuperAdmin']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Branch']);
        Role::create(['name' => 'Cashier']);

        User::factory()->super_admin()->create([
            'username' => 'superadmin',
            'password' => Hash::make('admin'),
            'name' => 'Super Admin',
        ]);
        User::factory()->admin()->create([
            'username' => 'owner1',
            'password' => Hash::make('123456'),
            'name' => 'John Doe',
        ]);


    }
}
