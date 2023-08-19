<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware('guest')->group(function() {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('user.auth');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('user.create');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('user.store');
});

Route::middleware('auth')->group(function() {
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('profile', function() {
        return Inertia::render('Profile');
    })->name('profile');
});

Route::resource('products', ProductController::class);

Route::resource('cart', CartItemController::class)
     ->except(['show', 'create', 'edit']);
Route::get('cart/clear', [CartItemController::class, 'clear'])->name('cart.clear');

Route::resource('orders', OrderController::class)->middleware('auth');

//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
