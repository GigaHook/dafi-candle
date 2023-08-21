<?php

namespace App\Services;
use App\Models\Order;

class OrderService 
{
    public function getOrders() {
        return auth()->check()
            ? Order::where('user_id', auth()->id())->load('orderitems')
            : Order::all()->load('orderitems');
    }

    public function createOrder() {

    }

    public function deleteOrder(Order $order) {

    }
}