<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@rangkita.com'],
            [
                'name' => 'Admin Rangkita',
                'password' => 'admin12345',
                'role' => 'admin',
            ]
        );
    }
}
