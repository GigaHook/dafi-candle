<?php

namespace App\Listeners;

use App\Models\User;
use App\Services\Cart\AuthCartService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DefStudio\Telegraph\Facades\Telegraph;
use Illuminate\Support\Str;

class HandleOrderPlacement
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        (new AuthCartService)->clearCart();

        $message = $this->generateMessage($event);
        Telegraph::message($message)->send();
    }

    private function generateMessage($event): string
    {
        //Str::after();
        return "zxc";
    } 

}
