<?php

namespace App\Providers;

use App\Events\OrderPlaced;
use App\Listeners\HandleOrderPlacement;
use App\Services\Cart\GuestCartService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        OrderPlaced::class => [
            HandleOrderPlacement::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {   
        /**
         * Сохранение товаров в корзине при регистрации
         */
        Event::listen(Registered::class, function (Registered $event) {
            (new GuestCartService)->transferItems($event->user);
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
