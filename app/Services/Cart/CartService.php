<?php

namespace App\Services\Cart;

abstract class CartService
{
    public $cart = [];

    /**
     * чтобы не собирать корзину 2 раза
     * @param mixed $method
     * @param mixed $argumetns
     * @return void
     */
    public function __call($method, $argumetns): void {
        $this->$method(...$argumetns);
        if ($method !== 'assembleCart') {
            $this->assembleCart();
        }
    }
}