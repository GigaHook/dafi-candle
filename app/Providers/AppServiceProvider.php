<?php

namespace App\Providers;

use App\Services\NotificationService;
use DefStudio\Telegraph\Models\TelegraphBot;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
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
