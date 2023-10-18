<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Relations\Pivot;

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
    }

    public function delete(Order $order, int $productId): void
    {
        $this->getOrderItem($order, $productId)->delete();
    }
}