<?php

namespace App\Http\Middleware;

use App\Services\BadgeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveOrderBadges
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        (new BadgeService)->unsetOrderBadges();

        //TODO мидлвары неработают, придумать как очищать беджи
        
        return $response;
    }
}
