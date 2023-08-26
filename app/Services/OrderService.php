<?php

namespace App\Services;
use App\Models\Adress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\AdressService;
use App\Services\Cart\AuthCartService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService 
{
    private $adressService;
    private $cartService;

    public function __construct() {
        $this->adressService = new AdressService;
        $this->cartService = new AuthCartService;
    }

    public function getOrders(): Collection {
        return auth()->user()->is_admin
            ? Order::query()->where('user_id', auth()->id())->load('orderitems')
            : Order::all()->load('orderitems');
    }

    public function createOrder(array $data): void {
        DB::transaction(function() use($data) {
            $adress = $this->adressService->createAdress($data);

            $order = Order::create([
                'user_id' => auth()->id(),
                'adress_id' => $adress->id,
                'price' => $this->cartService->getCart()['totalPrice'],
            ]);

            foreach ($this->cartService->getCart()['items'] as $product) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $product->quantity,
                ]);
            }
        });
    }

    public function deleteOrder(Order $order): void {

    }
}