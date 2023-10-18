<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderItemService;

class OrderItemController extends Controller
{
    public function __construct(
        private OrderItemService $orderItemService,
    ) {}
    
    public function store(Order $order, int $productId): void
    {
        $this->orderItemService->increase($order, $productId);
    }

    public function update(Order $order, int $productId): void
    {
        $this->orderItemService->decrease($order, $productId);
    }

    public function destroy(Order $order, int $productId): void
    {
        $this->orderItemService->delete($order, $productId);
    }
}
