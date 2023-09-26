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
     * Тут иконки(беджи)
     * @var 
     */
    private $badges;

    /**
     * Достаём из сессии массив с беджами, если нет, то создаём
     */
    public function __construct()
    {
        $this->badges = session()->has('badges') ? session()->pull('badges') : [];
    }

    /**
     * Ложим беджи обратно
     */
    public function __destruct() 
    {
        session()->put('badges', $this->badges);
    }

    /**
     * Устанавливаем беджи для заказов
     * Для админа - в сайдбар, для юзера - в профиль
     * @return void
     */
    private function setOrderBadges(): void 
    {
        if (auth()->user()?->is_admin) {
            $this->badges['ordersAdmin'] = Order::where([
                'viewed_admin' => false,
            ])->count();
        } else {
            $this->badges['ordersUser'] = Order::where([
                'viewed_user' => false,
                'user_id' => auth()->id(),
            ])->count();
        }
    }

    /**
     * Устанавливаем беджи для корзины
     * @return void
     */
    private function setCartBadges(): void 
    {
        $cartService = auth()->check() ? new AuthCartService : new GuestCartService;
        $items = $cartService->getCart()['items'];
        $this->badges['cart'] = collect($items)->where('viewed', false)->count();
    }

    /**
     * Установка всех беджей беджи заказов
     * @return void
     */
    public function setBadges(): void 
    {
        $this->setOrderBadges();
        $this->setCartBadges();
    }

    /**
     * Убираем беджи заказов
     * @return void
     */
    public function unsetOrderBadges(): void 
    {
        unset($this->badges['ordersAdmin']);
        unset($this->badges['ordersUser']);
    }

    /**
     * Убираем беджи корзины
     * @return void
     */
    public function unsetCartBadges(): void 
    {
        unset($this->badges['cart']);
    }
}

