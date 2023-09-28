<?php
use App\Services\Cart\AuthCartService;
use App\Services\Cart\GuestCartService;

if (!function_exists('toast')) { 
    function toast(string $text, string $type='DEFAULT'): void {
        session()->flash('toast', [
            'text' => $text,
            'type' => $type,
        ]);
    }
}

if (!function_exists('cartService')) {
    function cartService() {
        return auth()->check() ? new AuthCartService : new GuestCartService;
    }
}
