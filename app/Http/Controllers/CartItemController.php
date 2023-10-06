<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartItemController extends Controller
{
    public function __construct() {
        $this->middleware(function(Request $request, Closure $next) {
            //(new BadgeService)->setCartBadges();
            return $next($request);
        });
    }
    public function index(): \Inertia\Response 
    {
        return Inertia::render('Cart');
    }

    public function store(Request $request): void 
    {
        cartService()->addItem($request->id);
        (new BadgeService)->setCartBadges();
    }

    public function update(int $id): void 
    {
        cartService()->removeItem($id);
        (new BadgeService)->setCartBadges();
    }

    public function destroy(int $id): void 
    {
        cartService()->deleteItem($id);
        (new BadgeService)->setCartBadges();
    }

    public function clear(): void 
    {
        cartService()->clearCart();
        toast('Корзина очищена');
        (new BadgeService)->setCartBadges();
    }
}
