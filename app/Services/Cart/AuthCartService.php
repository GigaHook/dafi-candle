<?php

namespace App\Services\Cart;

use App\Services\Cart\CartService;
use App\Models\CartItem;
use App\Services\NotificationService;

class AuthCartService implements CartService
{
    public function __construct(
        private NotificationService $notificationService = new NotificationService
    ) {}
    public function getCart(): array {
        $cart = [
            'items' => [],
            'totalQuantity' => 0,
            'totalPrice' => 0,
        ];

        foreach (auth()->user()->products as $product) {
            $quantity = $product->cartItem->quantity;
            $product->quantity = $quantity;
            $cart['items'][] = $product;
            $cart['totalQuantity'] += $quantity;
            $cart['totalPrice'] += $quantity * $product->price;
        }

        return $cart;
    }

    public function addItem(int $id): void {
        $item = CartItem::firstWhere([
            'product_id' => $id,
            'user_id' => auth()->id(),
        ]);

        if (!$item) {
            CartItem::create([
                'product_id' => $id,
                'user_id' => auth()->id(),
                'quantity' => 1,
            ]);

            $this->notificationService->snackbar('Товар добавлен в корзину', 'mdi-cart-check');
        } else {
            $item->quantity++;
            $item->save();
        }
    }

    public function removeItem(int $id): void {
        $item = CartItem::firstWhere([
            'product_id' => $id,
            'user_id' => auth()->id(),
        ]);
        
        if ($item->quantity < 2) {
            $item->delete();
            $this->notificationService->snackbar('Товар удалён из корзины', 'mdi-cart-remove');
        } else {
            $item->quantity--;
            $item->save();
        }
    }

    public function deleteItem(int $id): void {
        CartItem::where([
            'product_id' => $id,
            'user_id' => auth()->id(),
        ])->delete();

        $this->notificationService->snackbar('Товар удалён из корзины', 'mdi-cart-remove');
    }

    public function clearCart(): void {
        CartItem::where(['user_id' => auth()->id()])->delete();
    }
}