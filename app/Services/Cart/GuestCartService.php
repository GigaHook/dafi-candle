<?php

namespace App\Services\Cart;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart\CartService;
use App\Services\NotificationService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class GuestCartService implements CartService
{
    private $cartItems;

    public function __construct(
        private NotificationService $notificationService = new NotificationService
    ) {
        if (!Cookie::has('cartItems')) {
            Cookie::queue('cartItems', serialize([]), now()->addMonth()->unix() / 60);
            $this->cartItems = [];
        } else {
            $this->cartItems = unserialize(Cookie::get('cartItems'));
        }
    }

    public function __destruct() {
        Cookie::queue('cartItems', serialize($this->cartItems), now()->addMonth()->unix() / 60);
    }

    public function getCart(): array {
        $cart = [
            'items' => [],
            'totalQuantity' => 0,
            'totalPrice' => 0,
        ];
        
        foreach ($this->cartItems as $item) {
            $product = Product::find($item['product_id']);
            $product->quantity = $item['quantity'];
            $cart['items'][] = $product;
            $cart['totalQuantity'] += $product->quantity;
            $cart['totalPrice'] += $product->quantity * $product->price;
        }
        
        return $cart;
    }

    public function addItem(int $id): void {
        if (Arr::has($this->cartItems, $id)) {
            $this->cartItems[$id]['quantity']++; 
        } else {
            $this->cartItems[$id] = [
                'product_id' => $id,
                'quantity' => 1,
            ];
            
        }
        $this->notificationService->snackbar('Товар добавлен в корзину', 'mdi-cart-check');
        
    }

    public function removeItem(int $id): void {
        if ($this->cartItems[$id]['quantity'] == 1) {
            unset($this->cartItems[$id]);
            $this->notificationService->snackbar('Товар удалён из корзины', 'mdi-cart-remove');

        } else {
            $this->cartItems[$id]['quantity']--;
        }
    }

    public function deleteItem(int $id): void {
        unset($this->cartItems[$id]);
        $this->notificationService->snackbar('Товар удалён из корзины', 'mdi-cart-remove');
    }

    public function clearCart(): void {
        $this->cartItems = [];
    }

    public function transferItems(User $user): void {
        if ($this->cartItems == []) return;

        foreach ($this->cartItems as $item) {
            CartItem::create([
                'product_id' => $item['product_id'],
                'user_id' => $user->id,
                'quantity' => $item['quantity'],
            ]);
        }

        $this->clearCart();
    }
}