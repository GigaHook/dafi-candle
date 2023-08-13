<?php

namespace App\Providers;

use App\Services\Cart\AuthCartService;
use App\Services\Cart\CartService;
use App\Services\Cart\CartServiceInterface;
use App\Services\Cart\GuestCartService;
use Illuminate\Support\Facades\Auth;
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
        //
    }
}
