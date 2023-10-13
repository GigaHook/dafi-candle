<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function store(OrderItem $orderItem): void
    {
        $orderItem->quantity++;
        $orderItem->save();
    }

    public function update(OrderItem $orderItem): void
    {
        $orderItem->quantity--;
        $orderItem->save();
    }

    public function destroy(OrderItem $orderItem): void
    {
        $orderItem->delete();
    }
}
