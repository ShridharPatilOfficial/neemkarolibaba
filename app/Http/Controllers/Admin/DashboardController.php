<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\ContactSubmission;
use App\Models\Event;
use App\Models\FounderMember;
use App\Models\FuturePlan;
use App\Models\GalleryItem;
use App\Models\JoinUsSubmission;
use App\Models\Partner;
use App\Models\Principle;
use App\Models\Slider;
use App\Models\VisitorLog;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ── Visitor stats ──────────────────────────────────────────
        $totalVisitors = VisitorLog::distinct('ip_address')->count('ip_address');
        $todayVisitors = VisitorLog::where('visited_date', today())->count();
        $monthVisitors = VisitorLog::whereMonth('visited_date', now()->month)
            ->whereYear('visited_date', now()->year)->count();
        $yesterdayVisitors = VisitorLog::where('visited_date', today()->subDay())->count();

        $visitorsLast7 = VisitorLog::select(DB::raw('visited_date, COUNT(*) as count'))
            ->where('visited_date', '>=', now()->subDays(6)->toDateString())
            ->groupBy('visited_date')
            ->orderBy('visited_date')
            ->get()
            ->keyBy('visited_date');

        $last7Days = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $last7Days[$date] = $visitorsLast7[$date]->count ?? 0;
        }

        // ── Submissions ────────────────────────────────────────────
        $joinSubmissions    = JoinUsSubmission::count();
        $unreadJoin         = JoinUsSubmission::where('is_read', false)->count();
        $contactSubmissions = ContactSubmission::count();
        $unreadContact      = ContactSubmission::where('is_read', false)->count();
        $todayJoin          = JoinUsSubmission::whereDate('created_at', today())->count();
        $todayContact       = ContactSubmission::whereDate('created_at', today())->count();

        // ── Content inventory ──────────────────────────────────────
        $contentCounts = [
            'sliders'     => Slider::count(),
            'events'      => Event::count(),
            'activities'  => Activity::count(),
            'gallery'     => GalleryItem::count(),
            'partners'    => Partner::count(),
            'members'     => FounderMember::count(),
            'future_plans'=> FuturePlan::count(),
            'principles'  => Principle::count(),
        ];

        // ── Recent submissions (latest 5 combined) ─────────────────
        $recentJoin = JoinUsSubmission::orderByDesc('created_at')->take(5)->get()
            ->map(fn($r) => (object)[
                'type'       => 'join',
                'name'       => $r->name,
                'email'      => $r->email,
                'is_read'    => $r->is_read,
                'created_at' => $r->created_at,
            ]);

        $recentContact = ContactSubmission::orderByDesc('created_at')->take(5)->get()
            ->map(fn($r) => (object)[
                'type'       => 'contact',
                'name'       => $r->name,
                'email'      => $r->email,
                'is_read'    => $r->is_read,
                'created_at' => $r->created_at,
            ]);

        $recentSubmissions = $recentJoin->concat($recentContact)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();

        // ── Monthly visitor trend (last 6 months) ──────────────────
        $monthlyVisitors = [];
        for ($m = 5; $m >= 0; $m--) {
            $month = now()->subMonths($m);
            $monthlyVisitors[$month->format('M')] = VisitorLog::whereMonth('visited_date', $month->month)
                ->whereYear('visited_date', $month->year)
                ->count();
        }

        // ── Top countries (for dashboard widget) ───────────────────
        $topCountries = VisitorLog::select('country', 'country_code', DB::raw('COUNT(*) as total'))
            ->whereNotNull('country')
            ->groupBy('country', 'country_code')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // ── Top India cities (for dashboard widget) ─────────────────
        $topIndiaCities = VisitorLog::select('city', 'region', DB::raw('COUNT(*) as total'))
            ->where('country_code', 'IN')
            ->whereNotNull('city')
            ->groupBy('city', 'region')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalVisitors',
            'todayVisitors',
            'monthVisitors',
            'yesterdayVisitors',
            'last7Days',
            'monthlyVisitors',
            'joinSubmissions',
            'unreadJoin',
            'contactSubmissions',
            'unreadContact',
            'todayJoin',
            'todayContact',
            'contentCounts',
            'recentSubmissions',
            'topCountries',
            'topIndiaCities'
        ));
    }
}
