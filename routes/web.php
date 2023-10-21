<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BadgeController;
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

Route::inertia('/', 'Home')->name('home');

//crud users
Route::middleware('guest')->group(function() {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('user.auth');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('user.create');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('user.store');
});

Route::middleware('auth')->group(function() {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::inertia('profile', 'Profile')->name('profile');
    //Route::inertia('about', 'about');

    //заказы
    Route::resource('orders', OrderController::class); //+ещё мидлвары в контроллере
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
});

//изменение заказа
Route::middleware(['auth', 'admin'])->group(function() {
    Route::post('orders/{order}/orderitems/{orderitem}', [OrderItemController::class, 'store'])
        ->name('orderitems.store');

    Route::patch('orders/{order}/orderitems/{orderitem}', [OrderItemController::class, 'update'])
        ->name('orderitems.update');

    Route::delete('orders/{order}/orderitems/{orderitem}', [OrderItemController::class, 'destroy'])
        ->name('orderitems.destroy');

});

//crud продукты
Route::resource('products', ProductController::class);

//корзина
Route::resource('cart', CartItemController::class)->except(['show', 'create', 'edit']);
Route::get('cart/clear', [CartItemController::class, 'clear'])->name('cart.clear');

//уведомления о заказах
Route::post('/badges', BadgeController::class)->name('badges');



//Route::middleware('auth')->group(function () {
//    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
