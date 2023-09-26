<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use App\Services\Cart\AuthCartService;
use App\Services\Cart\CartService;
use App\Services\Cart\GuestCartService;
use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CartItemController extends Controller
{
    public function __construct() 
    {
        $this->middleware(function(Request $request, Closure $next) {
            $response = $next($request);
            (new BadgeService)->unsetCartBadges();
            $this->cartService()->removeBadges();
            return $response;
        })->only(['index']);
    }

    private function cartService(): CartService 
    {
        return auth()->check() ? new AuthCartService : new GuestCartService;
    }
    
    public function index(): \Inertia\Response 
    {
        return Inertia::render('Cart', [
            'cart' => $this->cartService()->getCart(),
        ]);
    }

    public function store(Request $request): void 
    {
        $this->cartService()->addItem($request->id);
    }

    public function update(int $id): void 
    {
        $this->cartService()->removeItem($id);
    }

    public function destroy(int $id): void 
    {
        $this->cartService()->deleteItem($id);
    }

    public function clear(): void 
    {
        $this->cartService()->clearCart();
        toast('Корзина очищена');
    }
}
