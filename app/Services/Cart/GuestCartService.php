<?php

namespace App\Services\Cart;

use App\Services\Cart\CartService;
use App\Models\CartItem;

class GuestCartService extends CartService
{
    public $cart = [];

    public function __construct() {
        
    }

    public function assembleCart(): void {
        $this->cart['items'] = [];
        $this->cart['totalQuantity'] = 0;
        $this->cart['totalPrice'] = 0;
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