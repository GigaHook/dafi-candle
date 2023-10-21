<?php

namespace App\Services;

use App\Events\OrderContentsUpdated;
use App\Models\Order;
use App\Models\OrderItem;

class OrderItemService
{
    private function getOrderItem(Order $order, int $productId): OrderItem 
    {
        return OrderItem::where([
            'product_id' => $productId,
            'order_id' => $order->id,
        ])->first();
    }

    public function increase(Order $order, int $productId): void
    {   
        $orderItem = $this->getOrderItem($order, $productId);
        $orderItem->quantity++;
        $orderItem->save();
        
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
        }

        event(new OrderContentsUpdated($order));
    }

    public function delete(Order $order, int $productId): void
    {
        $this->getOrderItem($order, $productId)->delete();
        event(new OrderContentsUpdated($order));
    }
}