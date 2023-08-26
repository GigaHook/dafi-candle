<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('types')->insert([
            'name' => 'Контейнерная'
        ]);

        DB::table('types')->insert([
            'name' => 'Формовая'
        ]);

        DB::table('types')->insert([
            'name' => 'Ботаническая'
        ]);

        DB::table('types')->insert([
            'name' => 'Саше'
        ]);
    }
}
