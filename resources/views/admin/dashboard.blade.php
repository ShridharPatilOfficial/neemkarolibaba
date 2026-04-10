@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ── Row 1: Primary Stats ────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Total Visitors',    $totalVisitors,    'fa-globe',       'bg-blue-500',   'All-time unique IPs'],
        ["Today's Visitors",  $todayVisitors,    'fa-eye',         'bg-emerald-500','vs ' . $yesterdayVisitors . ' yesterday'],
        ['This Month',        $monthVisitors,    'fa-calendar',    'bg-orange-500', now()->format('F Y')],
        ['Join Submissions',  $joinSubmissions,  'fa-user-plus',   'bg-purple-600', $unreadJoin . ' unread'],
    ] as [$label, $value, $icon, $color, $sub])
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 {{ $color }} rounded-xl flex items-center justify-center flex-shrink-0 shadow">
            <i class="fas {{ $icon }} text-white text-xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-extrabold text-gray-900">{{ number_format($value) }}</p>
            <p class="text-gray-500 text-xs truncate">{{ $label }}</p>
            <p class="text-gray-400 text-[10px] mt-0.5">{{ $sub }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Row 2: Secondary Stats ──────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Contact Messages', $contactSubmissions, 'fa-envelope',    'bg-sky-500',    $unreadContact . ' unread'],
        ['Today Join',       $todayJoin,          'fa-user-check',  'bg-teal-500',   'new today'],
        ['Today Contact',    $todayContact,       'fa-inbox',       'bg-indigo-500', 'new today'],
        ['Total Content',    array_sum($contentCounts), 'fa-layer-group', 'bg-rose-500', 'across all sections'],
    ] as [$label, $value, $icon, $color, $sub])
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
        <div class="w-12 h-12 {{ $color }} rounded-xl flex items-center justify-center flex-shrink-0 shadow">
            <i class="fas {{ $icon }} text-white text-xl"></i>
        </div>
        <div class="min-w-0">
            <p class="text-2xl font-extrabold text-gray-900">{{ number_format($value) }}</p>
            <p class="text-gray-500 text-xs truncate">{{ $label }}</p>
            <p class="text-gray-400 text-[10px] mt-0.5">{{ $sub }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- ── Row 3: Charts ───────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Daily 7-day chart --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">Visitors — Last 7 Days</h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-lg">Daily</span>
        </div>
        <div class="flex items-end gap-2 h-36">
            @php $maxVal = max(array_values($last7Days) ?: [1]); @endphp
            @foreach($last7Days as $date => $count)
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[10px] text-gray-500 font-bold">{{ $count ?: '' }}</span>
                <div class="w-full rounded-t transition-all {{ $count > 0 ? 'bg-purple-500' : 'bg-gray-100' }}"
                     style="height: {{ $maxVal > 0 ? max(4, round(($count / $maxVal) * 110)) : 4 }}px"></div>
                <span class="text-[9px] text-gray-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($date)->format('d M') }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Monthly 6-month chart --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-900">Visitors — Last 6 Months</h3>
            <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-lg">Monthly</span>
        </div>
        <div class="flex items-end gap-3 h-36">
            @php $maxMonth = max(array_values($monthlyVisitors) ?: [1]); @endphp
            @foreach($monthlyVisitors as $month => $count)
            <div class="flex-1 flex flex-col items-center gap-1">
                <span class="text-[10px] text-gray-500 font-bold">{{ $count ?: '' }}</span>
                <div class="w-full rounded-t transition-all {{ $count > 0 ? 'bg-orange-400' : 'bg-gray-100' }}"
                     style="height: {{ $maxMonth > 0 ? max(4, round(($count / $maxMonth) * 110)) : 4 }}px"></div>
                <span class="text-[9px] text-gray-400">{{ $month }}</span>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- ── Row 3b: Geo Mini-Widgets ──────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Top Countries --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                <i class="fas fa-globe text-indigo-500"></i> Top Countries
            </h3>
            <a href="{{ route('admin.analytics') }}" class="text-xs text-purple-600 hover:underline font-semibold">Full Analytics →</a>
        </div>
        @php $cntTotal = $topCountries->sum('total') ?: 1; @endphp
        @if($topCountries->isEmpty())
        <p class="text-gray-400 text-xs text-center py-4">No geo data yet — resolves automatically as visitors arrive</p>
        @else
        <div class="space-y-2">
            @foreach($topCountries as $c)
            @php
                $pct = round($c->total / $cntTotal * 100);
                $flag = '';
                if ($c->country_code && strlen($c->country_code) === 2) {
                    $chars = str_split(strtoupper($c->country_code));
                    $flag = mb_chr(ord($chars[0]) - ord('A') + 0x1F1E6) . mb_chr(ord($chars[1]) - ord('A') + 0x1F1E6);
                }
            @endphp
            <div class="flex items-center gap-2">
                <span class="text-xl w-7 text-center">{{ $flag ?: '🌐' }}</span>
                <div class="flex-1">
                    <div class="flex justify-between text-xs mb-0.5">
                        <span class="font-semibold text-gray-700">{{ $c->country }}</span>
                        <span class="font-bold text-gray-600">{{ $c->total }} <span class="text-gray-400 font-normal">({{ $pct }}%)</span></span>
                    </div>
                    <div class="w-full bg-gray-100 rounded h-1.5 overflow-hidden">
                        <div class="h-1.5 bg-indigo-400 rounded" style="width:{{ max(2,$pct) }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Top India Cities --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-gray-900 text-sm flex items-center gap-2">
                <span class="text-lg">🇮🇳</span> India — Top Cities
            </h3>
            <a href="{{ route('admin.analytics') }}" class="text-xs text-purple-600 hover:underline font-semibold">Full Analytics →</a>
        </div>
        @if($topIndiaCities->isEmpty())
        <p class="text-gray-400 text-xs text-center py-4">No Indian visitor data yet</p>
        @else
        @php $icMax = $topIndiaCities->first()->total ?: 1; @endphp
        <div class="space-y-2">
            @foreach($topIndiaCities as $city)
            @php $pct = round($city->total / $icMax * 100); @endphp
            <div class="flex items-center gap-2">
                <i class="fas fa-map-pin text-orange-400 text-xs w-4 text-center"></i>
                <div class="flex-1">
                    <div class="flex justify-between text-xs mb-0.5">
                        <span class="font-semibold text-gray-700">{{ $city->city }}</span>
                        <span class="font-bold text-gray-600">{{ $city->total }}</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded h-1.5 overflow-hidden">
                        <div class="h-1.5 bg-orange-400 rounded" style="width:{{ max(2,$pct) }}%"></div>
                    </div>
                </div>
                <span class="text-[10px] text-gray-400 w-20 truncate">{{ $city->region }}</span>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- ── Row 4: Content Inventory + Submissions ─────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Content Inventory --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-layer-group text-purple-500"></i> Content Inventory
        </h3>
        <div class="grid grid-cols-2 gap-3">
            @foreach([
                ['Sliders',      $contentCounts['sliders'],      'fa-images',       'admin.sliders.index',       'bg-blue-50   text-blue-700'],
                ['Events',       $contentCounts['events'],       'fa-calendar-days','admin.content.index',       'bg-orange-50 text-orange-700', 'events'],
                ['Activities',   $contentCounts['activities'],   'fa-hands-helping','admin.content.index',       'bg-green-50  text-green-700',  'activities'],
                ['Gallery',      $contentCounts['gallery'],      'fa-photo-film',   'admin.gallery.index',       'bg-pink-50   text-pink-700'],
                ['Partners',     $contentCounts['partners'],     'fa-handshake',    'admin.partners.index',      'bg-indigo-50 text-indigo-700'],
                ['Members',      $contentCounts['members'],      'fa-users',        'admin.members.index',       'bg-teal-50   text-teal-700'],
                ['Future Plans', $contentCounts['future_plans'], 'fa-rocket',       'admin.content.index',       'bg-violet-50 text-violet-700', 'future-plans'],
                ['Principles',   $contentCounts['principles'],   'fa-layer-group',  'admin.principles.index',    'bg-rose-50   text-rose-700'],
            ] as $item)
            @php
                $routeParam = $item[5] ?? null;
                $url = $routeParam ? route($item[3], $routeParam) : route($item[3]);
            @endphp
            <a href="{{ $url }}"
               class="flex items-center gap-3 p-3 {{ $item[4] }} rounded-xl hover:opacity-80 transition group">
                <div class="w-8 h-8 bg-white rounded-lg shadow-sm flex items-center justify-center flex-shrink-0">
                    <i class="fas {{ $item[1] === 0 ? $item[2] . ' opacity-40' : $item[2] }} text-sm" style="color:inherit"></i>
                </div>
                <div>
                    <p class="font-bold text-lg leading-none">{{ $item[0] }}</p>
                    <p class="text-xs opacity-70 mt-0.5">{{ number_format($item[1]) }} items</p>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Submissions Overview --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-inbox text-blue-500"></i> Submissions Overview
        </h3>

        {{-- Summary rows --}}
        <div class="space-y-3 mb-5">
            <div class="flex items-center justify-between p-3 bg-orange-50 rounded-xl border border-orange-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-orange-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Join Us</p>
                        <p class="text-gray-400 text-xs">{{ $todayJoin }} new today</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-gray-900 text-lg">{{ $joinSubmissions }}</span>
                    @if($unreadJoin > 0)
                    <span class="bg-orange-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $unreadJoin }} new</span>
                    @endif
                    <a href="{{ route('admin.submissions.join-us') }}" class="text-xs text-purple-600 hover:underline font-semibold">View →</a>
                </div>
            </div>

            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-xl border border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-envelope text-blue-500 text-xs"></i>
                    </div>
                    <div>
                        <p class="font-semibold text-gray-800 text-sm">Contact Us</p>
                        <p class="text-gray-400 text-xs">{{ $todayContact }} new today</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-gray-900 text-lg">{{ $contactSubmissions }}</span>
                    @if($unreadContact > 0)
                    <span class="bg-blue-500 text-white text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $unreadContact }} new</span>
                    @endif
                    <a href="{{ route('admin.submissions.contact') }}" class="text-xs text-purple-600 hover:underline font-semibold">View →</a>
                </div>
            </div>
        </div>

        {{-- Recent submissions mini-table --}}
        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Recent Activity</h4>
        <div class="space-y-2">
            @forelse($recentSubmissions as $sub)
            <div class="flex items-center gap-3 py-1.5 border-b border-gray-50 last:border-0">
                <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 {{ $sub->type === 'join' ? 'bg-orange-100' : 'bg-blue-100' }}">
                    <i class="fas {{ $sub->type === 'join' ? 'fa-user-plus text-orange-500' : 'fa-envelope text-blue-500' }} text-[10px]"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-gray-800 text-xs font-semibold truncate">{{ $sub->name }}</p>
                    <p class="text-gray-400 text-[10px] truncate">{{ $sub->email }}</p>
                </div>
                <div class="flex items-center gap-1.5 flex-shrink-0">
                    @if(!$sub->is_read)
                    <span class="w-1.5 h-1.5 rounded-full bg-orange-400 inline-block"></span>
                    @endif
                    <span class="text-[10px] text-gray-400">{{ $sub->created_at->diffForHumans(null, true) }}</span>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-xs text-center py-3">No submissions yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Row 5: Quick Actions ────────────────────────────────────────── --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
        <i class="fas fa-bolt text-yellow-500"></i> Quick Actions
    </h3>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
        @foreach([
            ['Add Slider',     'admin.sliders.create',    'fa-image',       'bg-blue-50   text-blue-600'],
            ['Add Partner',    'admin.partners.create',   'fa-handshake',   'bg-green-50  text-green-600'],
            ['Add Member',     'admin.members.create',    'fa-user-plus',   'bg-purple-50 text-purple-600'],
            ['Add Gallery',    'admin.gallery.create',    'fa-photo-film',  'bg-pink-50   text-pink-600'],
            ['Add Principle',  'admin.principles.create', 'fa-layer-group', 'bg-rose-50   text-rose-600'],
            ['Site Settings',  'admin.settings',          'fa-cog',         'bg-gray-100  text-gray-600'],
        ] as [$label, $route, $icon, $cls])
        <a href="{{ route($route) }}" class="flex flex-col items-center gap-2 p-4 {{ $cls }} rounded-xl hover:opacity-80 transition text-center">
            <i class="fas {{ $icon }} text-xl"></i>
            <span class="text-xs font-semibold leading-tight">{{ $label }}</span>
        </a>
        @endforeach
    </div>
</div>

@endsection
