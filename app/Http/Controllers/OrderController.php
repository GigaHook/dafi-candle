<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Services\BadgeService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(
        private $orderService = new OrderService,
        private $badgeService = new BadgeService,
    ) {
        $this->middleware('admin')->only(['index', 'edit', 'update']);
        $this->middleware('badges.orders')->only(['index']);
    }

    public function index(): \Inertia\Response 
    {   
        $this->badgeService->removeOrdersBadges();

        return Inertia::render('Orders/OrdersIndex', [
            'orders' => $this->orderService->getOrders()
        ]);
    }

    public function create(): \Inertia\Response 
    {
        return Inertia::render('Orders/OrdersCreate');
    }

    public function store(OrderStoreRequest $request): void
    {
        $this->orderService->createOrder($request->validated());
    }

    public function show(Order $order): \Inertia\Response 
    {
        return auth()->user()->is_admin
            ? Inertia::render('Orders/OrdersShowAdmin', [
                "order" => $order->load("products")->load("adress")
            ])
            : Inertia::render('Orders/OrdersShowUser', [
                "order" => $order->load("products")->load("adress")
            ]);
    }

    public function edit(int $id): RedirectResponse
    {
        session()->put('editingOrder', $id);
        return redirect()->route("products.index");
    }

    public function update(OrderUpdateRequest $request, Order $order): void 
    {
        $this->orderService->updateOrder($order);
    }
    
    public function updateStatus(Request $request, Order $order): void
    {
        $this->orderService->updateStatus($order, $request->status);
    }

    public function destroy(Order $order): void 
    {
        $this->orderService->deleteOrder($order);
    }

    public function finishEdit(): void 
    {
        session()->forget('order');
    }
}
