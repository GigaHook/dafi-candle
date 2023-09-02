<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'asdasdasd',
            'email' => 'asd@asd.asd',
            'password' => Hash::make('asdasdasd'),
            'tel' => '+7 (111) 111-11-11',
            'is_admin' => 1,
        ]);

        DB::table('users')->insert([
            'name' => 'zxczxczxc',
            'email' => 'zxc@zxc.zxc',
            'password' => Hash::make('zxczxczxc'),
            'tel' => '+7 (222) 222-22-22',
            'is_admin' => 0,
        ]);
    }
}
