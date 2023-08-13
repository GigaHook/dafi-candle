<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Services\Cart\CartServiceInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;


class CartItemController extends Controller
{
    private $cartService;

    public function __construct(CartServiceInterface $cartService) {
        $this->cartService = $cartService;
    }

    public function index(): InertiaResponse {
        $this->cartService->assembleCart();
        return Inertia::render('Cart', [
            'cart' => $this->cartService->cart,
        ]);
    }

    public function store(Request $request): void {
        $this->cartService->addItem($request->id);
    }

    public function update(Request $request): void {
        $this->cartService->removeItem($request->id);
    }

    public function destroy(): void {
        $this->cartService->clearCart();
    }
}
