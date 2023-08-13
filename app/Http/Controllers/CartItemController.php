<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Services\Cart\AuthCartService;
use App\Services\Cart\GuestCartService;
use App\Services\Cart\CartService;
use App\Services\Cart\CartServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;


class CartItemController extends Controller
{
    public function index(): InertiaResponse {
        $this->defineCartClass()->assembleCart();
        return Inertia::render('Cart', [
            'cart' => $this->defineCartClass()->cart,
        ]);
    }

    public function store(Request $request): void {
        $this->defineCartClass()->addItem($request->id);
    }

    public function update(Request $request): void {
        $this->defineCartClass()->removeItem($request->id);
    }

    public function destroy(): void {
        $this->defineCartClass()->clearCart();
    }

    private function defineCartClass(): AuthCartService|GuestCartService {
        return auth()->check()
            ? new AuthCartService
            : new GuestCartService;
    }
}
