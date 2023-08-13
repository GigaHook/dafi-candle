<?php

namespace App\Services\Cart;

use App\Services\Cart\CartService;
use App\Models\CartItem;

class GuestCartService extends CartService implements CartServiceInterface
{

    public function assembleCart(): void {
        
    }

    public function addItem(int $id): void {
        
    }

    public function removeItem(int $id): void {
        
    }

    public function deleteItem(int $id): void {
        
    }

    public function clearCart(): void {
        
    }

    public static function transferItems(): void {

    }
}