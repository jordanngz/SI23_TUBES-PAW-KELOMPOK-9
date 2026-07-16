<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ],
            [
                'name' => 'Jordan_Ganteng',
                'email' => 'Jordan_Ganteng@gmail.com',
                'password' => Hash::make('jordan123'),
                'role' => 'user',
            ],
        ]);
    }
}