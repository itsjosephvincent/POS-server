<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::factory()->create([
            'role' => 'Owner',
        ]);
        Role::factory()->create([
            'role' => 'Manager',
        ]);
        Role::factory()->create([
            'role' => 'Staff',
        ]);

        User::factory()->create([
            'role_id' => 1,
            'username' => 'owner1',
            'password' => Hash::make('123456'),
            'name' => 'John Doe',
        ]);

        
    }
}
