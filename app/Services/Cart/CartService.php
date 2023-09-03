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
     * Добавляем в корзину всякое/увеличиваем кол-во
     * @param int $id
     * @return void
     */
    public function addItem(int $id): void;

    /**
     * Удаляем из корзины всякое/уменьшаем кол-во
     * @param int $id
     * @return void
     */
    public function removeItem(int $id): void;

    /**
     * Удаляем предмет из корзины
     * @param int $id
     * @return void
     */
    public function deleteItem(int $id): void;

    /**
     * Удаляем все предметы из корзины
     * @return void
     */
    public function clearCart(): void;
}