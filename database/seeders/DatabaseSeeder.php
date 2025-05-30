<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'mamedi@example.com',
            'password' => bcrypt("password123"),
        ]);
        User::create([
            'name' => 'Test User',
            'email' => 'amyndiaye@example.com',
            'password' => bcrypt("password123"),
        ]);
    }
}
