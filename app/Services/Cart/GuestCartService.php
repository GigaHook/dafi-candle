<?php

namespace App\Services\Cart;

use App\Models\Product;
use App\Services\Cart\CartService;
use App\Models\CartItem;
use Illuminate\Support\Facades\Cookie;

class GuestCartService extends CartService
{
    public function __construct() {
        if (!Cookie::has('cart')) {
            $cart = [
                'items' => collect([]),
                'totalQuantity' => 0,
                'totalPrice' => 0,
            ];

            $this->saveCart($cart);
        }
    }

    public function getCart(): array {
        $cart = unserialize(Cookie::get('cart'));

        $cart['totalQuantity'] = 0;
        $cart['totalPrice'] = 0;
    
        foreach ($cart['items'] as $item) {
            $product = Product::find($item['product_id']);
            //$cart['items'][$item] = $product; TODO чё за херь блять мозг умер 0,,,0
            $cart['items'] = $cart['items']->map(function($oldItem) use ($item) {
                return $oldItem == $item ? $item : $oldItem;
            });
            $cart['totalQuantity'] += $product->quantity;
            $cart['totalPrice'] += $product->quantity * $product->price;
        }
        
        return $cart;
    }

    public function addItem(int $id): void {
        $cart = unserialize(Cookie::get('cart'));
        $item = $cart['items']->firstWhere('product_id', $id);

        if (!$item) {
            $cart['items']->push(['product_id' => $id, 'quantity' => 1,]);
        } else {
            $cart['items'][$item]['quantity']++;
        }

        $this->saveCart($cart);
    }

    public function removeItem(int $id): void {
        
    }

    public function deleteItem(int $id): void {
        
    }

    public function clearCart(): void {
        
    }

    private function saveCart(array $cart): void {
        Cookie::queue('cart', serialize($cart), now()->addMonth()->unix() / 60);
    }
    
    public static function transferItems(): void {

    }
}