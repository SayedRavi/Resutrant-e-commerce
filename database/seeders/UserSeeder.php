<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('php123')
        ]);
        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'role' => 'user',
            'password' => Hash::make('php123')
        ]);
    }
}
