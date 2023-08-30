<?php

namespace App\Events;

use App\Models\Adress;
use App\Models\Order;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OrderPlaced
{
    use Dispatchable, SerializesModels;

    public $order;
    public $adress;


    /**
     * Create a new event instance.
     */
    public function __construct(Order $order, Adress $adress)
    {
        $this->order = $order;
        $this->adress = $adress;
    }
}
