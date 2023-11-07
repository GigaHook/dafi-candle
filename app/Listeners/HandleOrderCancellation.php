<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use DefStudio\Telegraph\Facades\Telegraph;

class HandleOrderCancellation
{
    /**us
     * Handle the event.
     */
    public function handle(OrderCancelled $event): void
    {
        toast('Заказ отменён');
        $message = $this->generateMessage($event->order);
        Telegraph::message($message)->send();
    }

    private function generateMessage($order): string
    {
        $datetime = $order->created_at->format('d.m.Y H:i');

        $message = "Отмена заказа <b>№{$order->id}</b>\nза {$datetime}\nот <b>{$order->adress->name} {$order->adress->lastname} {$order->adress->patronymic}</b>";

        return $message;
    }
}
