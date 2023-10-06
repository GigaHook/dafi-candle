<?php

namespace App\Listeners;

use App\Services\BadgeService;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SetBadgesAfterAuth
{
    /**
     * Handle the event.
     */
    public function handle(): void
    {
        $badgeService = new BadgeService;
        $badgeService->setOrdersBadges();
        $badgeService->setCartBadges();
    }
}
