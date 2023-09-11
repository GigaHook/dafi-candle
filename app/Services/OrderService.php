<?php

namespace App\Services;
use App\Events\OrderPlaced;
use App\Models\Adress;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\AdressService;
use App\Services\Cart\AuthCartService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService 
{
    public function __construct(
        private $adressService = new AdressService,
        private $cartService = new AuthCartService,
    ) {}

    public function getOrders(): Collection {
        return auth()->user()->is_admin
            ? Order::where('user_id', auth()->id())->get()->load('products')->load('adress') //для юзера
            : Order::get()->get()->load('products')->load('adress'); //для админа
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

            event(new OrderPlaced($order, $adress));
            toast('Заказ оформлен', 'success');
        });
    }

    public function deleteOrder(Order $order): void {

    }
}