<?php

namespace App\Listeners;

use App\Models\User;
use App\Services\Cart\GuestCartService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TransferCartItems
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        (new GuestCartService)->transferItems($event->user);
    }
}
