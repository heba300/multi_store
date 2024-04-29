<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get("/", [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductsController::class, 'show'])->name('products.show');

Route::resource('cart', CartController::class);



Route::get('/dash', function () {
    return view('dashboard');
})->middleware('auth');




Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
