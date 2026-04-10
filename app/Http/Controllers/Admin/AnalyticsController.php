<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisitorLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $range = $request->get('range', '30');   // today | 7 | 30 | all

        $query = VisitorLog::query();
        if ($range === 'today') {
            $query->where('visited_date', today());
        } elseif (is_numeric($range)) {
            $query->where('visited_date', '>=', now()->subDays((int)$range - 1)->toDateString());
        }
        // 'all' — no filter

        // ── Summary ────────────────────────────────────────────────
        $totalHits     = (clone $query)->count();
        $uniqueIPs     = (clone $query)->distinct('ip_address')->count('ip_address');
        $totalCountries= (clone $query)->whereNotNull('country')->distinct('country')->count('country');
        $totalCities   = (clone $query)->whereNotNull('city')->distinct('city')->count('city');

        // ── Countries ──────────────────────────────────────────────
        $countries = (clone $query)
            ->select('country', 'country_code', DB::raw('COUNT(*) as total'))
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->limit(30)
            ->get();

        // ── Cities (all top 20) ────────────────────────────────────
        $topCities = (clone $query)
            ->select('city', 'region', 'country', 'country_code', DB::raw('COUNT(*) as total'))
            ->whereNotNull('city')
            ->groupBy('city', 'region', 'country', 'country_code')
            ->orderByDesc('total')
            ->limit(20)
            ->get();

        // ── India cities ───────────────────────────────────────────
        $indiaCities = (clone $query)
            ->select('city', 'region', DB::raw('COUNT(*) as total'))
            ->where('country_code', 'IN')
            ->whereNotNull('city')
            ->groupBy('city', 'region')
            ->orderByDesc('total')
            ->limit(25)
            ->get();

        // ── India states/regions ───────────────────────────────────
        $indiaStates = (clone $query)
            ->select('region', DB::raw('COUNT(*) as total'))
            ->where('country_code', 'IN')
            ->whereNotNull('region')
            ->groupBy('region')
            ->orderByDesc('total')
            ->limit(20)
            ->get();

        // ── Device types ───────────────────────────────────────────
        $devices = (clone $query)
            ->select('device_type', DB::raw('COUNT(*) as total'))
            ->whereNotNull('device_type')
            ->groupBy('device_type')
            ->orderByDesc('total')
            ->get();

        // ── Browsers ───────────────────────────────────────────────
        $browsers = (clone $query)
            ->select('browser', DB::raw('COUNT(*) as total'))
            ->whereNotNull('browser')
            ->groupBy('browser')
            ->orderByDesc('total')
            ->get();

        // ── Operating systems ──────────────────────────────────────
        $osStats = (clone $query)
            ->select('os', DB::raw('COUNT(*) as total'))
            ->whereNotNull('os')
            ->groupBy('os')
            ->orderByDesc('total')
            ->get();

        // ── Top pages ──────────────────────────────────────────────
        $topPages = (clone $query)
            ->select('page_url', DB::raw('COUNT(*) as total'))
            ->whereNotNull('page_url')
            ->groupBy('page_url')
            ->orderByDesc('total')
            ->limit(15)
            ->get();

        // ── Hourly distribution (0–23) ─────────────────────────────
        $hourlyRaw = (clone $query)
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour')
            ->get()
            ->keyBy('hour');

        $hourly = [];
        for ($h = 0; $h < 24; $h++) {
            $hourly[$h] = $hourlyRaw[$h]->total ?? 0;
        }

        // ── Daily trend (last 30 days regardless of range) ─────────
        $dailyRaw = VisitorLog::select('visited_date', DB::raw('COUNT(*) as total'))
            ->where('visited_date', '>=', now()->subDays(29)->toDateString())
            ->groupBy('visited_date')
            ->orderBy('visited_date')
            ->get()
            ->keyBy('visited_date');

        $dailyTrend = [];
        for ($d = 29; $d >= 0; $d--) {
            $date = now()->subDays($d)->toDateString();
            $dailyTrend[$date] = $dailyRaw[$date]->total ?? 0;
        }

        // ── ISP / Network ──────────────────────────────────────────
        $isps = (clone $query)
            ->select('isp', DB::raw('COUNT(*) as total'))
            ->whereNotNull('isp')
            ->groupBy('isp')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // ── Referrers ──────────────────────────────────────────────
        $referrers = (clone $query)
            ->select('referrer', DB::raw('COUNT(*) as total'))
            ->whereNotNull('referrer')
            ->groupBy('referrer')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // ── New vs returning (approximate — unique IP seen multiple days) ──
        $newVisitors = VisitorLog::select('ip_address')
            ->groupBy('ip_address')
            ->havingRaw('COUNT(DISTINCT visited_date) = 1')
            ->count();
        $returningVisitors = VisitorLog::select('ip_address')
            ->groupBy('ip_address')
            ->havingRaw('COUNT(DISTINCT visited_date) > 1')
            ->count();

        return view('admin.analytics', compact(
            'range',
            'totalHits', 'uniqueIPs', 'totalCountries', 'totalCities',
            'countries', 'topCities', 'indiaCities', 'indiaStates',
            'devices', 'browsers', 'osStats',
            'topPages', 'hourly', 'dailyTrend',
            'isps', 'referrers',
            'newVisitors', 'returningVisitors'
        ));
    }
}
