<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Services\Cart\AuthCartService;
use DefStudio\Telegraph\Facades\Telegraph;

class HandleOrderPlacement
{
    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        toast('Заказ оформлен');
        (new AuthCartService)->clearCart();
        $message = $this->generateMessage($event->order, $event->adress);
        Telegraph::message($message)->send();
    }

    private function generateMessage($order, $adress): string
    {
        $message = "Новый заказ от <b>{$adress->name} {$adress->lastname} {$adress->patronymic}</b>\n\nСодержание:\n";
        
        foreach ($order->products as $product) {
            $quantity = $product->orderItem->quantity;
            $total = $product->price * $quantity;

            $message .= "<i>{$product->name}</i> за {$product->price}р х{$quantity} - {$total}р\n";
        }

        $message .= "\n<b>Итого: {$order->price}р</b>";

        return $message;
    }
}
