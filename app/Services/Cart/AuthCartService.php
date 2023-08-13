<?php

namespace App\Services\Cart;

use App\Services\Cart\CartService;
use App\Models\CartItem;
use Illuminate\Support\Facades\DB;

class AuthCartService extends CartService
{
    public $cart = [];

    public function assembleCart(): void {
        $this->cart['items'] = [];
        $this->cart['totalQuantity'] = 0;
        $this->cart['totalPrice'] = 0;
        
        foreach (auth()->user()->products as $product) {
            $quantity = $product->cartItem->quantity;
            $product->quantity = $quantity;
            $this->cart['items'][] = $product;
            $this->cart['totalQuantity'] += $quantity;
            $this->cart['totalPrice'] += $quantity * $product->price;
        }
    }

    public function addItem(int $id): void {
        CartItem::updateOrCreate([
            'product_id' => $id,
            'user_id' => auth()->id(),
        ], [
            'quantity' => DB::raw('quantity + 1'),
        ]);
        //TODO не работает добавление
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