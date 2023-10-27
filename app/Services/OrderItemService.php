<?php

namespace App\Services;

use App\Events\OrderContentsUpdated;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemService
{
    private function getOrderItem(Order $order, int $productId): OrderItem
    {
        return OrderItem::firstOrCreate([
            'product_id' => $productId,
            'order_id' => $order->id,
        ], [
            'quantity' => 0,
        ]);
    }

    public function increase(Order $order, int $productId): void
    {   
        $orderItem = $this->getOrderItem($order, $productId);

        $orderItem->quantity++;
        $orderItem->save();

        if ($orderItem->quantity == 1) {
            toast('Товар добавлен в заказ');
        }

        event(new OrderContentsUpdated($order));
    }

    public function decrease(Order $order, int $productId): void
    {
        $orderItem = $this->getOrderItem($order, $productId);

        if ($orderItem->quantity > 1) {
            $orderItem->quantity--;
            $orderItem->save();
        } else {
            $orderItem->delete();
            toast('Товар удалён из заказа');
        }

        event(new OrderContentsUpdated($order));
    }

    public function delete(Order $order, int $productId): void
    {
        $this->getOrderItem($order, $productId)->delete();
        toast('Товар удалён из заказа');
        event(new OrderContentsUpdated($order));
    }
}