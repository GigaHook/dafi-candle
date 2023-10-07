<?php

namespace App\Services;

use App\Models\Order;

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
}






