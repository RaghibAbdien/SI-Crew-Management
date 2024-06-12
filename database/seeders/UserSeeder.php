<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Admin 1',
            'email' => 'admin1@test.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'nama' => 'Admin 2',
            'email' => 'admin2@test.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'nama' => 'Admin 3',
            'email' => 'admin3@test.com',
            'password' => Hash::make('admin123'),
        ]);

        User::create([
            'nama' => 'Admin 4',
            'email' => 'admin4@test.com',
            'password' => Hash::make('admin123'),
        ]);
    }
}
