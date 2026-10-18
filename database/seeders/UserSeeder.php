<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Administrateur par défaut documenté dans le README
        User::updateOrCreate(
            ['email' => 'admin@catalog.local'],
            [
                'name' => 'Administrateur Portfolio',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
            ]
        );

        // Utilisateur standard de test
        User::updateOrCreate(
            ['email' => 'demo@catalog.local'],
            [
                'name' => 'Utilisateur Démo',
                'password' => Hash::make('Password123!'),
                'email_verified_at' => now(),
            ]
        );
    }
}
