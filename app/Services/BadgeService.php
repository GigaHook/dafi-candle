<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Order;
use App\Services\Cart\AuthCartService;
use App\Services\Cart\CartService;
use App\Services\Cart\GuestCartService;
use Illuminate\Http\Request;

class BadgeService
{
    private $badges;

    public function __construct(
        private Request $request,
    )
    {
        $this->badges = $request->session()->has('badges') ? $request->session()->pull('badges') : [];
    }

    public function __destruct() 
    {
        $this->request->session()->put('badges', $this->badges);
    }

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

    private function setCartBadges(): void 
    {
        $cartService = auth()->check() ? new AuthCartService : new GuestCartService;
        $items = $cartService->getCart()['items'];
        $this->badges['cart'] = collect($items)->where('viewed', false)->count();
    }

    public function setBadges(): void 
    {
        $this->setOrderBadges();
        $this->setCartBadges();
    }

    public function unsetOrderBadges(): void 
    {
        unset($this->badges['ordersAdmin']);
        unset($this->badges['ordersUser']);
    }

    public function unsetCartBadges(): void 
    {
        unset($this->badges['cart']);
    }
}

