<?php

namespace App\Services\Cart;

abstract class CartService
{
    /**
     * Получаем корзину
     * @return array
     */
    abstract public function getCart(): array;

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