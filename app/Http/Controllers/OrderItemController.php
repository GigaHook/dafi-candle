<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderItemService;

class OrderItemController extends Controller
{
    public function __construct(
        private OrderItemService $orderItemService,
    ) {}
    
    public function store(Order $orderItem, int $productId): void
    {
        $this->orderItemService->increase($orderItem, $productId);
    }

    public function update(Order $orderItem, int $productId): void
    {
        $this->orderItemService->decrease($orderItem, $productId);
    }

    public function destroy(Order $orderItem, int $productId): void
    {
        $this->orderItemService->delete($orderItem, $productId);
    }
}
