<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;

class SiteLock
{
    public function handle(Request $request, Closure $next)
    {
        if (SiteSetting::get('site_locked') !== '1') {
            return $next($request);
        }

        $path = $request->path();

        // Always allow: admin, inauguration page, unlock action, health check, sitemap
        if (
            str_starts_with($path, 'admin') ||
            $path === 'inauguration' ||
            $path === 'site-unlock' ||
            $path === 'site-unlocked' ||
            $path === 'sitemap.xml' ||
            $path === 'up'
        ) {
            return $next($request);
        }

        // Storage/asset requests pass through
        if (str_starts_with($path, 'storage/')) {
            return $next($request);
        }

        return redirect()->route('inauguration');
    }
}
