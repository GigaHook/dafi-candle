<?php

namespace App\Listeners;

use App\Models\User;
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
        $message = $this->generateMessage($event->order, $event->adress);
        //Telegraph::message($message)->send();
    }

    private function generateMessage($order, $adress): string
    {
        /*$message = "Новый заказ от "
                  ."<b>".$adress->name." "
                  .$adress->lastname."<//b>/n/n"
                  ."Содержание:/n";

        foreach ($order->products as $product) {
            $message .= $product->name." x".$product->orderItem->quantity."/n";
        }*/
        
        //return $message;
        return 'asdzxc';
    } 

}
