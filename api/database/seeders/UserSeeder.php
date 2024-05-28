<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'firstName' => 'Admin',
                'lastName' => 'User',
                'role' => 'admin',
                'CIN' => 'CIN123456',
                'image' => 'path/to/admin/image.jpg',
                'email' => 'admin@example.com',
                'employerBadge' => 'admin123',
                'email_verified_at' => now(),
                'password' => '$2y$12$oue0/tgy5Y6ZlE5Cg1aGqOJGnhH.an32sbGfTYi6SaDz50BLwRsUa', // Use a secure password
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'firstName' => 'Normal',
                'lastName' => 'User',
                'role' => 'user',
                'CIN' => 'CIN654321',
                'image' => 'path/to/normal/image.jpg',
                'email' => 'user@example.com',
                'employerBadge' => 'user123',
                'email_verified_at' => now(),
                'password' => '$2y$12$oue0/tgy5Y6ZlE5Cg1aGqOJGnhH.an32sbGfTYi6SaDz50BLwRsUa', // Use a secure password
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
