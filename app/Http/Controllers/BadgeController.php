<?php

namespace App\Http\Controllers;

use App\Services\BadgeService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        if ((new OrderService)->checkForNewOrders() && $request->path() != 'orders') {
            (new BadgeService)->setOrdersBadges();
        }
    }
}
