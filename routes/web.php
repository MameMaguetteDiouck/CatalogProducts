<?php

use App\Http\Controllers\AlimentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BtpController;
use App\Http\Controllers\CosmetiqueController;
use App\Http\Controllers\ElectroniqueController;
use App\Http\Controllers\HabillementController;
use App\Http\Controllers\ProduitController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProduitController::class, 'home'])->name('home');
Route::get('/products', [ProduitController::class, 'index'])->name('products.index')->middleware('auth');
Route::get('/products/{type}', [ProduitController::class, 'seeMore'])->name('products.seeMore');
Route::post('/products/search/{vue}', [ProduitController::class, 'search'])->name('products.search');

Route::controller(AlimentController::class)->prefix('/products/aliments')->middleware('auth')->group(function () {
    Route::get('/edit/{id}', 'edit')->name('aliments.edit');
    Route::get('/index',  'index')->name('aliments.index');
    Route::get('/create', 'create')->name('aliments.create');
    Route::post('/store', 'store')->name('aliments.store');
    Route::put('/update/{id}', 'update')->name('aliments.update');
    Route::delete('/destroy/{id}', 'destroy')->name('aliments.destroy');
});

Route::controller(ElectroniqueController::class)->prefix('/products/electroniques/')->middleware('auth')->group(function(){
    Route::get('/index', 'index')->name('electroniques.index');
    Route::get('/edit/{id}', 'edit')->name('electroniques.edit');
    Route::get('/create', 'create')->name('electroniques.create');
    Route::post('/store', 'store')->name('electroniques.store');
    Route::put('/update/{id}', 'update')->name('electroniques.update');
    Route::delete('/destroy/{id}', 'destroy')->name('electroniques.destroy');
});
Route::controller(HabillementController::class)->prefix('/products/habillements/')->middleware('auth')->group(function(){
    Route::get('/index', action: 'index')->name('habillements.index');
    Route::get('/edit/{id}', 'edit')->name('habillements.edit');
    Route::get('/create', 'create')->name('habillements.create');
    Route::post('/store', 'store')->name('habillements.store');
    Route::put('/update/{id}', 'update')->name('habillements.update');
    Route::delete('/destroy/{id}', 'destroy')->name('habillements.destroy');
});
Route::controller(BtpController::class)->prefix('/products/btps/')->middleware('auth')->group(function(){
    Route::get('/index', 'index')->name('btps.index');
    Route::get('/edit/{id}', 'edit')->name('btps.edit');
    Route::get('/create/', 'create')->name('btps.create');
    Route::post('/store', 'store')->name('btps.store');
    Route::put('/update/{id}', 'update')->name('btps.update');
    Route::delete('/destroy/{id}', 'destroy')->name('btps.destroy');
});
Route::controller(CosmetiqueController::class)->prefix('/products/cosmetiques/')->middleware('auth')->group(function(){
    Route::get('/index', 'index')->name('cosmetiques.index');
    Route::get('/edit/{id}', 'edit')->name('cosmetiques.edit');
    Route::get('/create/', 'create')->name('cosmetiques.create');
    Route::post('/store', 'store')->name('cosmetiques.store');
    Route::put('/update/{id}', 'update')->name('cosmetiques.update');
    Route::delete('/destroy/{id}', 'destroy')->name('cosmetiques.destroy');
});


Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
