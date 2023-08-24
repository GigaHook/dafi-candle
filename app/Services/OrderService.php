<?php

namespace App\Services;
use App\Models\Adress;
use App\Models\Order;
use App\Services\AdressService;
use App\Services\Cart\AuthCartService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService 
{
    private $adressService;
    private $cartService;
    private $order;

    public function __construct() {
        $this->adressService = new AdressService;
        $this->cartService = new AuthCartService;
    }

    public function getOrders(): Collection {
        return auth()->user()->is_admin
            ? Order::query()->where('user_id', auth()->id())->load('orderitems')
            : Order::all()->load('orderitems');
    }

    public function createOrder(array $data) {
        DB::transaction(function() use($data) {
            //creataAdress           
            //createOrderBase
            //fillOrder
        });
    }

    private function createOrderBase() {
        
    }

    private function fillOrder() {

    }

    public function deleteOrder(Order $order) {

    }
}