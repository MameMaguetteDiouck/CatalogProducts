<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds with roles.
     */
    public function run(): void
    {
        // 1. Administrateur principal (accès total + gestion des utilisateurs)
        User::updateOrCreate(
            ['email' => 'admin@catalog.local'],
            [
                'name' => 'Directeur Général',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::ADMIN,
                'email_verified_at' => now(),
                'must_change_password' => false,
            ]
        );

        // 2. Gestionnaire de catalogue (gestion des produits sans suppression ni gestion d'équipe)
        User::updateOrCreate(
            ['email' => 'demo@catalog.local'],
            [
                'name' => 'Gestionnaire des Stocks',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::MANAGER,
                'email_verified_at' => now(),
                'must_change_password' => false,
            ]
        );

        // 3. Nouveau collaborateur en attente de définition de son mot de passe
        User::updateOrCreate(
            ['email' => 'nouveau@catalog.local'],
            [
                'name' => 'Aïssatou Ba',
                'password' => Hash::make('Password123!'),
                'role' => UserRole::MANAGER,
                'email_verified_at' => now(),
                'must_change_password' => true,
            ]
        );
    }
}
