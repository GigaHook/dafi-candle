<?php

namespace App\Services\Cart;

use App\Services\Cart\CartService;
use App\Models\CartItem;

class AuthCartService extends CartService
{
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
        $item = CartItem::firstOrCreate([
            'product_id' => $id,
            'user_id' => auth()->id(),
        ], [
            'quantity' => 1,
        ]);

        if ($item->quantity == 1) {
            $item->quantity++;
            $item->save();
        }
    }

    public function removeItem(int $id): void {
        CartItem::where([
            'product_id' => $id,
            'user_id' => auth()->id(),
        ])->update(function($item) {
            if ($item->quantity < 2) $item->delete();
            else $item->quantity--;
        });
    }

    public function deleteItem(int $id): void {
        CartItem::where([
            'product_id' => $id,
            'user_id' => auth()->id(),
        ])->delete();
    }

    public function clearCart(): void {
        CartItem::where(['user_id' => auth()->id()])->delete();
    }
}