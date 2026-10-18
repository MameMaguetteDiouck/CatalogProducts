<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Catalogue public vitrine
Route::get('/', [ProductController::class, 'home'])->name('home');

// Gestion complète des produits (RESTful avec authentification pour les mutations)
Route::resource('products', ProductController::class);

// Authentification utilisateur
Auth::routes();
