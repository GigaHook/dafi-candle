<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\OrderPlacedAlternative;
use App\Services\Cart\AuthCartService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DefStudio\Telegraph\Facades\Telegraph;

class HandleOrderPlacement
{
    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        (new AuthCartService)->clearCart();

        $message = $this->generateMessage();

        $response = Telegraph::message($message)->send();
        
        User::find(2)->notify(new OrderPlacedAlternative());
        /*if ($response->telegraphError()) {
            try {
            } catch (\Exception) {
                dd($event);
            }
        }*/

    }

    private function generateMessage(): string
    {
        return "zxc";
    }

}
