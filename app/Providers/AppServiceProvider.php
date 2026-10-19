<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Seuls les administrateurs peuvent gérer l'équipe d'utilisateurs
        Gate::define('manage-users', function (User $user) {
            return $user->isAdmin();
        });

        // Seuls les administrateurs peuvent supprimer définitivement un produit du catalogue
        Gate::define('delete-product', function (User $user) {
            return $user->isAdmin();
        });
    }
}
