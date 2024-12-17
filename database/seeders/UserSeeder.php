<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a single user without User factory
        User::create([
            'fullname' => 'John Doe',
            'username' => 'doe123',
            'email' => 'doe@example.com',
            'email_verified_at' => now(),
            'is_admin' => true,
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // Generate random users using the User factory
        User::factory(5)->create();
    }
}
