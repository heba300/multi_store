<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dash', function () {
    return view('dashboard');
})->middleware('auth');

// Route::middleware('auth')->group(function () {
//         Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//         Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//         Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


//     });



//
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';