<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (range(1, 32) as $i) {
            DB::table('products')->insert([
                'name' => Str::random(),
                'description' => Str::random(120),
                'type_id' => rand(1, 4),
            ]);
            //TODO сделать фабрику 
        }
    }
}
