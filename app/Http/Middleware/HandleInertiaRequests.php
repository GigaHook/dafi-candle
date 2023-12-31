<?php

namespace App\Http\Middleware;

use App\Models\Order;
use App\Models\Type;
use App\Services\BadgeService;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'user'   => auth()->user(),
            'types'  => Type::all(), //TODO убрать этот позор отсюда нахуй
            'toast'  => session('toast'),
            'badges' => session('badges'),
            'cart'   => cartService()->getCart(),
            'order'  => Order::find(session('editingOrder'))?->load('products'),
            'back'   => getBackUrl(),
            'ziggy'  => function() use ($request) {
                return array_merge((new Ziggy)->toArray(), [
                    'location' => $request->url(),
                ]);
            },
        ]);
    }
}
