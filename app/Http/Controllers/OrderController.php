<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Services\BadgeService;
use App\Services\Cart\AuthCartService;
use App\Services\OrderService;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(
        private $orderService = new OrderService,
        private $cartService = new AuthCartService,
        private $badgeService = new BadgeService,

    ) {
        $this->middleware('admin')->only(["index"]);

        $this->middleware(function(Request $request, Closure $next) {
            $this->badgeService->unsetCartBadges();
            $this->orderService->removeBadges();
            dd(session('badges'));
            return $next($request);
        })->only(['index']);
    }

    public function index(): \Inertia\Response 
    {
        return Inertia::render('Orders/OrdersIndex', [
            'orders' => $this->orderService->getOrders()
        ]);
    }

    public function create(): \Inertia\Response 
    {
        return Inertia::render('Orders/OrdersCreate', [
            'cart' => $this->cartService->getCart(),
        ]);
    }

    public function store(OrderStoreRequest $request): void
    {
        $this->orderService->createOrder($request->validated());
    }

    public function show(Order $order): \Inertia\Response 
    {
        return auth()->user()->is_admin
            ? Inertia::render('Orders/OrdersAdminShow', [
                "order" => $order->load("products")->load("adress")
            ])
            : Inertia::render('Orders/OrdersShow', [
                "order" => $order->load("products")->load("adress")
            ]);
    }

    public function edit(Order $order): \Inertia\Response 
    {
        return Inertia::render();
    }

    public function update(OrderUpdateRequest $request, Order $order): void 
    {
        $this->orderService->updateOrder($order, $request->validated());
    }
    
    public function updateStatus(Request $request, Order $order): void
    {
        $this->orderService->updateStatus($order, $request->status);
    }

    public function destroy(Order $order): void 
    {
        $this->orderService->deleteOrder($order);
    }
}
