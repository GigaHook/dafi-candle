<?php

namespace App\Http\Middleware;

use App\Services\BadgeService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PutBadgesIntoSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        (new BadgeService($request))->setBadges();

        return $next($request);
    }
}
