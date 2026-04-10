<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip();
        $today = now()->toDateString();

        $exists = VisitorLog::where('ip_address', $ip)
            ->where('visited_date', $today)
            ->exists();

        if (!$exists) {
            VisitorLog::create([
                'ip_address'   => $ip,
                'user_agent'   => substr($request->userAgent() ?? '', 0, 255),
                'page_url'     => substr($request->fullUrl(), 0, 500),
                'visited_date' => $today,
            ]);
        }

        return $next($request);
    }
}
