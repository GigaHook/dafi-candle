<?php

namespace App\Http\Controllers;

use App\Services\Cart\AuthCartService;
use App\Services\Cart\CartService;
use App\Services\Cart\GuestCartService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class CartItemController extends Controller
{
    private function cartService(): CartService {
        return auth()->check()
            ? new AuthCartService
            : new GuestCartService;
    }
    
    public function index(): InertiaResponse {
        return Inertia::render('Cart', [
            'cart' => $this->cartService()->getCart(),
        ]);
    }

    public function store(Request $request): void {
        $this->cartService()->addItem($request->id);
    }

    public function update(Request $request): void {
        $this->cartService()->removeItem($request->id);
    }

    public function destroy(): void {
        $this->cartService()->clearCart();
    }
}
