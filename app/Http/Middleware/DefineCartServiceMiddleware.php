<?php

namespace App\Http\Middleware;

use App\Services\Cart\AuthCartService;
use App\Services\Cart\CartServiceInterface;
use App\Services\Cart\GuestCartService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DefineCartServiceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            app()->instance(CartServiceInterface::class, new AuthCartService);
        } else {
            app()->instance(CartServiceInterface::class, new GuestCartService);
        }

        return $next($request);
    }
}
