<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Services\Cart\AuthCartService;
use App\Services\Cart\CartService;
use App\Services\Cart\GuestCartService;
use Illuminate\Http\Request;

/**
 * Управление иконками уведомлений внутри сессии
 */
class BadgeService
{
    /**
     * Устанавливаем беджи для заказов
     * Для админа - в сайдбар, для юзера - в профиль
     * @return void
     */
    public function setOrdersBadges(): void 
    {
        $badges = session()->pull('badges');

        if (auth()->user()?->is_admin) {
            $badges['ordersAdmin'] = Order::where([
                'viewed_admin' => false,
            ])->count();
        } else {
            $badges['ordersUser'] = Order::where([
                'viewed_user' => false,
            ])->count();
        }

        session(['badges' => $badges]);
    }

    /**
     * Устанавливаем беджи для корзины
     * @return void
     */
    public function setCartBadges(): void 
    {
        //$cartService = auth()->check() ? new AuthCartService : new GuestCartService;
        //$items = $cartService->getCart()['items'];
        //$this->badges['cart'] = collect($items)->where('viewed', false)->count();
    }

    /**
     * Убираем беджи заказов
     * @return void
     */
    public function removeOrdersBadges(): void 
    {   
        $badges = session()->pull('badges');
        $badges['ordersAdmin'] = 0;
        $badges['ordersUser'] = 0;
        session(['badges' => $badges]);
    }

    /**
     * Убираем беджи корзины
     * @return void
     */
    public function removeCartBadges(): void 
    {
        //unset($this->badges['cart']);
    }
}

//v1
//order observer -> on create -> session(admin badges)++ -> set badges -> remove on index vitit
//order observer -> on status change -> session(user badges)++ -> set badges -> remove on profile visit





