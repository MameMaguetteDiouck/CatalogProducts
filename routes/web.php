<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Vitrine publique
Route::get('/', [ProductController::class, 'home'])->name('home');

// Espace de gestion (strictement réservé aux utilisateurs authentifiés)
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // Administration des utilisateurs et attribution des rôles
    Route::resource('users', \App\Http\Controllers\UserController::class)->except(['show']);

    // Gestion du profil personnel
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.password');

    // Changement obligatoire de mot de passe lors du premier accès / après reset
    Route::get('/password/first-login', [\App\Http\Controllers\Auth\ForcePasswordChangeController::class, 'showChangeForm'])->name('password.first_login');
    Route::post('/password/first-login', [\App\Http\Controllers\Auth\ForcePasswordChangeController::class, 'updatePassword'])->name('password.first_login.update');
});

// Consultation publique de la fiche détail d'un produit (enregistré après /products/create)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Authentification (Connexion, Déconnexion sans inscription ni reset email/SMTP)
Auth::routes(['register' => false, 'reset' => false]);
