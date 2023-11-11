<?php
use App\Services\Cart\AuthCartService;
use App\Services\Cart\GuestCartService;

if (!function_exists('toast')) { 
    function toast(string $text, string $type='DEFAULT'): void 
    {
        session()->flash('toast', [
            'text' => $text,
            'type' => $type,
        ]);
    }
}

if (!function_exists('cartService')) 
{
    function cartService() {
        return auth()->check() ? new AuthCartService : new GuestCartService;
    }
}

if (!function_exists('getBackUrl')) {
    function getBackUrl(): string 
    {
        $from = request()->header('referer');
        $to = request()->fullUrl();
        $back = session()->has('back') ? session('back') : route('products.index');

        if ($from == $to) {
            return $back;
        } 
        
        if (request()->method() != 'GET') {
            return $back;
        }

        session()->put('back', $from ?? route('products.index'));

        return $from ?? route('products.index');
    }
}
