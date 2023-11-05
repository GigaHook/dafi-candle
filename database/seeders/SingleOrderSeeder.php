<?php

namespace Database\Seeders;

use App\Events\OrderPlaced;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SingleOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()->hasAttached(Product::first(), [
            'quantity' => rand(1, 10)
        ])->create();
    }
}
