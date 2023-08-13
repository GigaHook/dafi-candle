<?php

namespace App\Services\Cart;

abstract class CartService
{

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
    
    /**
     * Наполняет корзину всяким
     * @return void
     */
    abstract public function assembleCart(): void;

    /**
     * Добавляет в корзину всякое/увеличивает кол-во
     * @param int $id
     * @return void
     */
    abstract public function addItem(int $id): void;

    /**
     * Удаляет из корзины всякое/уменьшает кол-во
     * @param int $id
     * @return void
     */
    abstract public function removeItem(int $id): void;

    /**
     * Полностью удаляет предмет из корзины, несмотря на его кол-во
     * @param int $id
     * @return void
     */
    abstract public function deleteItem(int $id): void;

    /**
     * Удаляет все предметы из корзины
     * @return void
     */
    abstract public function clearCart(): void;
}