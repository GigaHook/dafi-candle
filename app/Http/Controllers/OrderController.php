<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Models\Order;
use App\Services\Cart\AuthCartService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(
        private $orderService = new OrderService,
        private $cartService = new AuthCartService,
    ) {}

    public function index(): \Inertia\Response {
        return Inertia::render('Orders/OrdersIndex', [
            'orders' => $this->orderService->getOrders()
        ]);
    }

    public function create(): \Inertia\Response {
        return Inertia::render('Orders/OrdersCreate', [
            'cart' => $this->cartService->getCart(),
        ]);
    }

    public function store(OrderStoreRequest $request) {
        $this->orderService->createOrder($request->validated());
    }

    public function show(Order $order) {
        //
    }

    public function edit(Order $order) {
        //
    }

    public function update(Request $request, Order $order) {
        //
    }

    public function destroy(Order $order) {
        $this->orderService->deleteOrder($order);
    }
}
