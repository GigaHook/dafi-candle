<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Models\Order;
use App\Models\Type;
use App\Services\BadgeService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(
        private $orderService = new OrderService,
        private $badgeService = new BadgeService,
        private $productService = new ProductService,
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
        return Inertia::render('Orders/OrdersShowAdmin', [
            "order" => $order->load("products")->load("adress")
        ]);
    }

    public function edit(Request $request, int $id): \Inertia\Response 
    {
        session()->put('editingOrder', $id);

        return Inertia::render('Products/ProductsIndex', [
            'products' => $this->productService->processProducts($request->all()),
            'types' => Type::all(),
            'order' => Order::find($id)->load('products'),
        ]);
    }
    
    public function finishEdit(): void 
    {
        session()->forget('order');
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
}
