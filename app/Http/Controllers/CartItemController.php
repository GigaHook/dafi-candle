<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CartItemController extends Controller
{
    public function index(): \Inertia\Response 
    {
        return Inertia::render('Cart');
    }

    public function store(Request $request): void 
    {
        cartService()->addItem($request->id);
    }

    public function update(int $id): void 
    {
        cartService()->removeItem($id);
    }

    public function destroy(int $id): void 
    {
        cartService()->deleteItem($id);
    }

    public function clear(): void 
    {
        cartService()->clearCart();
        toast('Корзина очищена');
    }
}
