<?php

namespace App\Services;
use App\Events\OrderPlaced;
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

    public function getOrders(): Collection 
    {
        return auth()->user()->is_admin
            ? Order::where('user_id', auth()->id())->latest()->get()->load('adress') //для юзера
            : Order::latest()->get()->load('adress'); //для админа
    }

    public function createOrder(array $data): void 
    {
        DB::transaction(function() use($data) {
            $adress = $this->adressService->createAdress($data);

            //TODO: пересчитать стоимость после изменения содержания заказа
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
        });
    }

    public function updateStatus(Order $order, string $status): void 
    {
        $order->status = $status;
        $order->save();
    }

    public function updateOrder(Order $order, array $data): void 
    {
        //
    }

    public function deleteOrder(Order $order): void
    {
        $order->delete();
    }

    public function viewOrders(): void
    {
        $role = auth()->user()?->is_admin ? 'viewed_admin' : 'viewed_user';
        Order::where($role, false)->update([$role => true]);
    }
    
    public function checkForNewOrders(): bool 
    {
        return !Order::where('viewed_admin', false)->get()->isEmpty();
    }
}