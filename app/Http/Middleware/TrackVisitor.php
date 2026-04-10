<?php

namespace App\Http\Middleware;

use App\Models\VisitorLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip    = $request->ip();
        $today = now()->toDateString();

        $log = VisitorLog::where('ip_address', $ip)
            ->where('visited_date', $today)
            ->first();

        if (!$log) {
            $ua      = substr($request->userAgent() ?? '', 0, 500);
            $device  = $this->parseDevice($ua);
            $referrer = substr($request->headers->get('referer', '') ?? '', 0, 500) ?: null;

            $log = VisitorLog::create([
                'ip_address'   => $ip,
                'user_agent'   => substr($ua, 0, 255),
                'page_url'     => substr($request->fullUrl(), 0, 500),
                'visited_date' => $today,
                'device_type'  => $device['device'],
                'browser'      => $device['browser'],
                'os'           => $device['os'],
                'referrer'     => $referrer,
                'geo_resolved' => false,
            ]);

            // Geo lookup — skip private/loopback IPs
            if (!$this->isPrivateIp($ip)) {
                try {
                    $geo = Http::timeout(3)->get(
                        "http://ip-api.com/json/{$ip}?fields=status,country,countryCode,regionName,city,timezone,isp,lat,lon"
                    )->json();

                    if (($geo['status'] ?? '') === 'success') {
                        $log->update([
                            'country'      => $geo['country']     ?? null,
                            'country_code' => $geo['countryCode'] ?? null,
                            'region'       => $geo['regionName']  ?? null,
                            'city'         => $geo['city']        ?? null,
                            'timezone'     => $geo['timezone']    ?? null,
                            'isp'          => $geo['isp']         ?? null,
                            'lat'          => $geo['lat']         ?? null,
                            'lon'          => $geo['lon']         ?? null,
                            'geo_resolved' => true,
                        ]);
                    }
                } catch (\Throwable) {
                    // fail silently — geo is non-critical
                }
            }
        }

        return $next($request);
    }

    // ── Helpers ──────────────────────────────────────────────────────

    private function isPrivateIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false;
    }

    private function parseDevice(string $ua): array
    {
        $ua = strtolower($ua);

        // Browser (order matters — Edge/OPR must come before Chrome)
        $browser = 'Other';
        if (str_contains($ua, 'edg/') || str_contains($ua, 'edge/'))  $browser = 'Edge';
        elseif (str_contains($ua, 'opr/') || str_contains($ua, 'opera')) $browser = 'Opera';
        elseif (str_contains($ua, 'samsungbrowser'))                   $browser = 'Samsung';
        elseif (str_contains($ua, 'ucbrowser'))                        $browser = 'UC Browser';
        elseif (str_contains($ua, 'firefox/'))                         $browser = 'Firefox';
        elseif (str_contains($ua, 'chrome/') && !str_contains($ua, 'chromium')) $browser = 'Chrome';
        elseif (str_contains($ua, 'safari/') && !str_contains($ua, 'chrome'))   $browser = 'Safari';
        elseif (str_contains($ua, 'msie') || str_contains($ua, 'trident/'))     $browser = 'IE';

        // OS
        $os = 'Other';
        if (str_contains($ua, 'windows nt'))                          $os = 'Windows';
        elseif (str_contains($ua, 'iphone') || str_contains($ua, 'ipad')) $os = 'iOS';
        elseif (str_contains($ua, 'android'))                          $os = 'Android';
        elseif (str_contains($ua, 'mac os x'))                         $os = 'macOS';
        elseif (str_contains($ua, 'linux'))                            $os = 'Linux';

        // Device
        $device = 'Desktop';
        if (str_contains($ua, 'ipad') || (str_contains($ua, 'android') && !str_contains($ua, 'mobile'))) {
            $device = 'Tablet';
        } elseif (str_contains($ua, 'mobile') || str_contains($ua, 'iphone') ||
                  str_contains($ua, 'android')) {
            $device = 'Mobile';
        }

        return compact('browser', 'os', 'device');
    }
}
