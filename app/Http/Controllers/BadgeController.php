<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if (!(new OrderService)->checkForNewOrders()) {
            if ($request->location != '/orders') {
                (new BadgeService)->setOrdersBadges();
            }
        }
        

        //запрос сюда раз в 5 сек (только если user->is_admin)
        //если есть заказы с viewedAdmin = false
        //ререндерим компонент с новым заказом, если мы на странице с заказами, ставим viewedAdmin = true
        //+badges
        //toast(new order)
        //
        //
    }
}
