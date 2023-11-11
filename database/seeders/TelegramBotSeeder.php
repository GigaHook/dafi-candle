<?php

namespace Database\Seeders;

use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TelegramBotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TelegraphBot::firstOrCreate([
            'token' => env('TELEGRAM_BOT_TOKEN'),
            'name' => env('TELEGRAM_BOT_NAME'),
        ])->chats()->firstOrCreate([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'name' => env('TELEGRAM_CHAT_NAME'),
        ]);
    }
}
