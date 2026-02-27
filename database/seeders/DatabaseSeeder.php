<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
{
    User::firstOrCreate(
        ['email' => 'test@example.com'],
        ['name' => 'Test User', 'password' => \Illuminate\Support\Facades\Hash::make('password')]
    );

    User::firstOrCreate(
        ['email' => 'adminnew@admin.com'],
        [
            'name'     => 'Admin',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role'     => 'admin',
        ]
    );
}
}
