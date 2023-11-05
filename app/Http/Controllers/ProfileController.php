<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Services\OrderService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ProfileController extends Controller
{
    public function __construct(
        private OrderService $orderService,
    ) {}
    public function index(): \Inertia\Response
    {
        return Inertia::render('Profile', [
            'orders' => $this->orderService->getOrders(),
        ]);
    }
}
