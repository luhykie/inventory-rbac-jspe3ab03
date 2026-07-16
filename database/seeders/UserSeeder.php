<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'System Administrator', 'email' => 'admin@inventory.test'],
            ['name' => 'Receiving Clerk',      'email' => 'clerk@inventory.test'],
            ['name' => 'Inventory Manager',    'email' => 'manager@inventory.test'],
            ['name' => 'Inventory Supervisor', 'email' => 'supervisor@inventory.test'],
            ['name' => 'Reports Officer',      'email' => 'reports@inventory.test'],
        ];

        foreach ($users as $user) {
            User::firstOrCreate(
                ['email' => $user['email']],
                ['name' => $user['name'], 'password' => Hash::make('password')]
            );
        }
    }
}
