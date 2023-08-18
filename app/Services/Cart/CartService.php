<?php

namespace App\Services\Cart;

interface CartService
{
    /**
     * Получаем корзину
     * @return array
     */
    public function getCart(): array;

    /**
     * Добавляет в корзину всякое/увеличивает кол-во
     * @param int $id
     * @return void
     */
    public function addItem(int $id): void;

    /**
     * Удаляет из корзины всякое/уменьшает кол-во
     * @param int $id
     * @return void
     */
    public function removeItem(int $id): void;

    /**
     * Полностью удаляет предмет из корзины, несмотря на его кол-во
     * @param int $id
     * @return void
     */
    public function deleteItem(int $id): void;

    /**
     * Удаляет все предметы из корзины
     * @return void
     */
    public function clearCart(): void;
}