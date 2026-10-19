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

// Consultation publique de la fiche détail d'un produit
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

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
});

// Authentification (Connexion, Déconnexion)
Auth::routes(['register' => false]);
