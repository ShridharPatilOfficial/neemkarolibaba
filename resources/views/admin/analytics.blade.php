@extends('admin.layouts.app')
@section('title', 'Visitor Analytics')

@push('styles')
<style>
.ana-card   { background:#fff; border-radius:14px; border:1px solid #e8eaf0; padding:1.25rem 1.5rem; }
.ana-badge  { display:inline-block; padding:2px 9px; border-radius:20px; font-size:0.68rem; font-weight:700; }
.bar-track  { background:#f1f5f9; border-radius:4px; height:8px; overflow:hidden; }
.bar-fill   { height:8px; border-radius:4px; transition:width .5s; }
.range-tab  { padding:6px 14px; border-radius:8px; font-size:0.78rem; font-weight:600; cursor:pointer; border:1.5px solid #e2e8f0; color:#64748b; background:#fff; transition:all .2s; }
.range-tab.active { background:#4f46e5; color:#fff; border-color:#4f46e5; }
.flag       { font-size:1.15rem; line-height:1; }
.hour-cell  { width:100%; aspect-ratio:1; border-radius:3px; }
</style>
@endpush

@section('content')

{{-- ── Header ──────────────────────────────────────────────────────── --}}
<div class="flex flex-wrap items-center justify-between gap-3 mb-6">
    <div>
        <h1 class="text-xl font-extrabold text-gray-900">Visitor Analytics</h1>
        <p class="text-gray-400 text-xs mt-0.5">In-depth visitor tracking — geo, device, behaviour</p>
    </div>
    {{-- Range Tabs --}}
    <form method="GET" action="{{ route('admin.analytics') }}" id="rangeForm">
        <div class="flex gap-2 flex-wrap">
            @foreach(['today'=>'Today','7'=>'Last 7 Days','30'=>'Last 30 Days','all'=>'All Time'] as $val=>$label)
            <button type="submit" name="range" value="{{ $val }}"
                    class="range-tab {{ $range == $val ? 'active' : '' }}">
                {{ $label }}
            </button>
            @endforeach
        </div>
    </form>
</div>

{{-- ── Row 1: Summary Stats ─────────────────────────────────────────── --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    @foreach([
        ['Total Hits',       $totalHits,         'fa-mouse-pointer', 'bg-indigo-500',  'Page visits in range'],
        ['Unique Visitors',  $uniqueIPs,          'fa-fingerprint',   'bg-emerald-500', 'Distinct IP addresses'],
        ['Countries',        $totalCountries,     'fa-globe',         'bg-orange-500',  'Unique countries tracked'],
        ['Cities',           $totalCities,        'fa-city',          'bg-purple-600',  'Unique cities tracked'],
    ] as [$label, $value, $icon, $color, $sub])
    <div class="ana-card flex items-center gap-4">
        <div class="w-12 h-12 {{ $color }} rounded-xl flex items-center justify-center flex-shrink-0 shadow">
            <i class="fas {{ $icon }} text-white text-xl"></i>
        </div>
        <div>
            <p class="text-2xl font-extrabold text-gray-900">{{ number_format($value) }}</p>
            <p class="text-gray-500 text-xs">{{ $label }}</p>
            <p class="text-gray-400 text-[10px]">{{ $sub }}</p>
        </div>
    </div>
    @endforeach
</div>

{{-- New vs Returning --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">

    {{-- New vs Returning widget --}}
    <div class="ana-card flex flex-col justify-between">
        <h3 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
            <i class="fas fa-users text-indigo-500"></i> New vs Returning
        </h3>
        @php
            $nvTotal = $newVisitors + $returningVisitors;
            $nvPct   = $nvTotal > 0 ? round($newVisitors / $nvTotal * 100) : 0;
        @endphp
        <div class="flex items-center gap-4 mb-3">
            <div class="text-center flex-1">
                <p class="text-3xl font-extrabold text-indigo-600">{{ $nvPct }}%</p>
                <p class="text-xs text-gray-400">New</p>
            </div>
            <div class="w-px h-10 bg-gray-200"></div>
            <div class="text-center flex-1">
                <p class="text-3xl font-extrabold text-emerald-600">{{ 100 - $nvPct }}%</p>
                <p class="text-xs text-gray-400">Returning</p>
            </div>
        </div>
        <div class="bar-track">
            <div class="bar-fill bg-indigo-500" style="width:{{ $nvPct }}%"></div>
        </div>
        <p class="text-[10px] text-gray-400 mt-1">{{ number_format($newVisitors) }} new · {{ number_format($returningVisitors) }} returning (all-time)</p>
    </div>

    {{-- Device Types --}}
    <div class="ana-card">
        <h3 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
            <i class="fas fa-mobile-screen text-blue-500"></i> Devices
        </h3>
        @php
            $devTotal = $devices->sum('total') ?: 1;
            $devColors = ['Mobile'=>'bg-blue-500','Desktop'=>'bg-purple-500','Tablet'=>'bg-teal-500','Other'=>'bg-gray-400'];
            $devIcons  = ['Mobile'=>'fa-mobile-alt','Desktop'=>'fa-desktop','Tablet'=>'fa-tablet-alt','Other'=>'fa-question'];
        @endphp
        <div class="space-y-2.5">
            @forelse($devices as $d)
            @php $pct = round($d->total / $devTotal * 100); @endphp
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="flex items-center gap-1.5 font-semibold text-gray-700">
                        <i class="fas {{ $devIcons[$d->device_type] ?? 'fa-question' }} text-gray-400 text-[10px]"></i>
                        {{ $d->device_type ?? 'Unknown' }}
                    </span>
                    <span class="font-bold text-gray-600">{{ number_format($d->total) }} <span class="text-gray-400 font-normal">({{ $pct }}%)</span></span>
                </div>
                <div class="bar-track">
                    <div class="bar-fill {{ $devColors[$d->device_type] ?? 'bg-gray-400' }}" style="width:{{ $pct }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-xs">No data yet</p>
            @endforelse
        </div>
    </div>

    {{-- Browsers --}}
    <div class="ana-card">
        <h3 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
            <i class="fas fa-window-maximize text-orange-500"></i> Browsers
        </h3>
        @php
            $brTotal = $browsers->sum('total') ?: 1;
            $brColors = ['Chrome'=>'bg-yellow-500','Firefox'=>'bg-orange-500','Safari'=>'bg-blue-400','Edge'=>'bg-indigo-500','Opera'=>'bg-red-500','Samsung'=>'bg-teal-500','Other'=>'bg-gray-400'];
        @endphp
        <div class="space-y-2.5">
            @forelse($browsers as $b)
            @php $pct = round($b->total / $brTotal * 100); @endphp
            <div>
                <div class="flex justify-between text-xs mb-1">
                    <span class="font-semibold text-gray-700">{{ $b->browser ?? 'Unknown' }}</span>
                    <span class="font-bold text-gray-600">{{ number_format($b->total) }} <span class="text-gray-400 font-normal">({{ $pct }}%)</span></span>
                </div>
                <div class="bar-track">
                    <div class="bar-fill {{ $brColors[$b->browser] ?? 'bg-gray-400' }}" style="width:{{ $pct }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-xs">No data yet</p>
            @endforelse
        </div>
    </div>
</div>

{{-- ── Row 3: Countries + OS ────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Country List (takes 2 cols) --}}
    <div class="ana-card lg:col-span-2">
        <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
            <i class="fas fa-globe text-indigo-500"></i> Visitors by Country
            <span class="ml-auto text-[10px] bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $countries->count() }} tracked</span>
        </h3>
        @php $cTotal = $countries->sum('total') ?: 1; @endphp
        @if($countries->isEmpty())
        <p class="text-gray-400 text-xs text-center py-6">No geo data yet — visitors will be resolved automatically</p>
        @else
        <div class="space-y-2 max-h-[420px] overflow-y-auto pr-1" style="scrollbar-width:thin;">
            @foreach($countries as $i => $c)
            @php
                $pct = round($c->total / $cTotal * 100);
                $flagOffset = $c->country_code ? strtolower($c->country_code) : '';
                // Convert country code to flag emoji using regional indicator symbols
                $flag = '';
                if ($flagOffset && strlen($flagOffset) === 2) {
                    $chars = str_split(strtoupper($c->country_code));
                    $flag = mb_chr(ord($chars[0]) - ord('A') + 0x1F1E6) . mb_chr(ord($chars[1]) - ord('A') + 0x1F1E6);
                }
            @endphp
            <div class="flex items-center gap-3">
                <span class="text-xl w-7 text-center flex-shrink-0">{{ $flag ?: '🌐' }}</span>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between text-xs mb-0.5">
                        <span class="font-semibold text-gray-800 truncate">{{ $c->country ?? 'Unknown' }}</span>
                        <span class="font-bold text-gray-600 ml-2 flex-shrink-0">{{ number_format($c->total) }}
                            <span class="text-gray-400 font-normal text-[10px]">({{ $pct }}%)</span>
                        </span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill {{ $i === 0 ? 'bg-indigo-500' : ($i < 3 ? 'bg-indigo-400' : 'bg-indigo-200') }}"
                             style="width:{{ max(2,$pct) }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- OS Stats --}}
    <div class="ana-card">
        <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
            <i class="fas fa-microchip text-purple-500"></i> Operating Systems
        </h3>
        @php
            $osTotal  = $osStats->sum('total') ?: 1;
            $osColors = ['Windows'=>'bg-blue-500','Android'=>'bg-green-500','iOS'=>'bg-gray-600','macOS'=>'bg-gray-500','Linux'=>'bg-orange-500','Other'=>'bg-gray-300'];
            $osIcons  = ['Windows'=>'fa-windows','Android'=>'fa-android','iOS'=>'fa-apple','macOS'=>'fa-apple','Linux'=>'fa-linux','Other'=>'fa-question'];
        @endphp
        <div class="space-y-3">
            @forelse($osStats as $o)
            @php $pct = round($o->total / $osTotal * 100); @endphp
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 {{ $osColors[$o->os] ?? 'bg-gray-300' }} rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm">
                    <i class="fab {{ $osIcons[$o->os] ?? 'fas fa-question' }} text-white text-xs"></i>
                </div>
                <div class="flex-1">
                    <div class="flex justify-between text-xs mb-0.5">
                        <span class="font-semibold text-gray-700">{{ $o->os ?? 'Unknown' }}</span>
                        <span class="font-bold text-gray-600">{{ $pct }}%</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill {{ $osColors[$o->os] ?? 'bg-gray-300' }}" style="width:{{ max(2,$pct) }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-xs text-center py-4">No data yet</p>
            @endforelse
        </div>

        {{-- Referrers mini --}}
        @if($referrers->isNotEmpty())
        <div class="mt-5 pt-4 border-t border-gray-100">
            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Top Referrers</h4>
            <div class="space-y-1.5">
                @foreach($referrers->take(5) as $ref)
                <div class="flex justify-between text-xs">
                    <span class="text-gray-600 truncate max-w-[160px]">{{ parse_url($ref->referrer, PHP_URL_HOST) ?: $ref->referrer }}</span>
                    <span class="font-bold text-gray-700 ml-2 flex-shrink-0">{{ number_format($ref->total) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

{{-- ── India Deep Dive ──────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- India Cities --}}
    <div class="ana-card">
        <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
            <span class="text-xl">🇮🇳</span> India — Cities
            <span class="ml-auto text-[10px] bg-orange-50 text-orange-600 border border-orange-200 px-2 py-0.5 rounded-full">{{ $indiaCities->count() }} cities</span>
        </h3>
        @if($indiaCities->isEmpty())
        <p class="text-gray-400 text-xs text-center py-8">No Indian visitors tracked yet</p>
        @else
        @php $icMax = $indiaCities->first()->total ?: 1; @endphp
        <div class="space-y-2 max-h-[360px] overflow-y-auto pr-1" style="scrollbar-width:thin;">
            @foreach($indiaCities as $city)
            @php $pct = round($city->total / $icMax * 100); @endphp
            <div class="flex items-center gap-2">
                <div class="w-32 text-xs font-semibold text-gray-700 truncate flex-shrink-0">{{ $city->city }}</div>
                <div class="flex-1">
                    <div class="bar-track">
                        <div class="bar-fill bg-orange-400" style="width:{{ max(3,$pct) }}%"></div>
                    </div>
                </div>
                <div class="text-xs font-bold text-gray-600 w-8 text-right">{{ $city->total }}</div>
                <div class="text-[10px] text-gray-400 w-24 truncate">{{ $city->region }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- India States --}}
    <div class="ana-card">
        <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
            <span class="text-xl">🇮🇳</span> India — States / Regions
            <span class="ml-auto text-[10px] bg-orange-50 text-orange-600 border border-orange-200 px-2 py-0.5 rounded-full">{{ $indiaStates->count() }} states</span>
        </h3>
        @if($indiaStates->isEmpty())
        <p class="text-gray-400 text-xs text-center py-8">No Indian visitor data yet</p>
        @else
        @php $isMax = $indiaStates->first()->total ?: 1; @endphp
        <div class="space-y-2 max-h-[360px] overflow-y-auto pr-1" style="scrollbar-width:thin;">
            @foreach($indiaStates as $state)
            @php $pct = round($state->total / $isMax * 100); @endphp
            <div class="flex items-center gap-2">
                <div class="w-36 text-xs font-semibold text-gray-700 truncate flex-shrink-0">{{ $state->region }}</div>
                <div class="flex-1">
                    <div class="bar-track">
                        <div class="bar-fill bg-emerald-500" style="width:{{ max(3,$pct) }}%"></div>
                    </div>
                </div>
                <div class="text-xs font-bold text-gray-600 w-8 text-right">{{ $state->total }}</div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

{{-- ── Daily Trend (30 days) + Hourly Heatmap ─────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-5 gap-6 mb-6">

    {{-- Daily trend (3/5 cols) --}}
    <div class="ana-card lg:col-span-3">
        <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
            <i class="fas fa-chart-area text-indigo-500"></i> Daily Traffic — Last 30 Days
        </h3>
        @php $dMax = max(array_values($dailyTrend) ?: [1]); @endphp
        <div class="flex items-end gap-1 h-28">
            @foreach($dailyTrend as $date => $cnt)
            @php
                $barH = $dMax > 0 ? max(2, round(($cnt / $dMax) * 90)) : 2;
                $isToday = $date === now()->toDateString();
            @endphp
            <div class="flex-1 flex flex-col items-center gap-0.5 group relative" title="{{ \Carbon\Carbon::parse($date)->format('d M') }}: {{ $cnt }} visits">
                @if($cnt > 0)<span class="text-[8px] text-gray-400 opacity-0 group-hover:opacity-100 absolute -top-4">{{ $cnt }}</span>@endif
                <div class="w-full rounded-t {{ $isToday ? 'bg-orange-500' : ($cnt > 0 ? 'bg-indigo-400' : 'bg-gray-100') }}"
                     style="height:{{ $barH }}px"></div>
            </div>
            @endforeach
        </div>
        <div class="flex justify-between text-[9px] text-gray-400 mt-1">
            <span>{{ \Carbon\Carbon::parse(array_key_first($dailyTrend))->format('d M') }}</span>
            <span>Today</span>
        </div>
    </div>

    {{-- Hourly heatmap (2/5 cols) --}}
    <div class="ana-card lg:col-span-2">
        <h3 class="font-bold text-gray-800 text-sm mb-1 flex items-center gap-2">
            <i class="fas fa-clock text-purple-500"></i> Visits by Hour (UTC)
        </h3>
        @php
            $rangeLabel = match($range) {
                'today' => 'today',
                '7'     => 'last 7 days',
                '30'    => 'last 30 days',
                default => 'all time',
            };
        @endphp
        <p class="text-[10px] text-gray-400 mb-3">Hourly traffic distribution for <strong>{{ $rangeLabel }}</strong>. Shows which hours get the most visitors — useful for scheduling posts or ads. Each square = 1 hour (00–23 UTC). Darker = more visitors.</p>

        @php $hMax = max($hourly ?: [1]); @endphp

        {{-- Hour grid: 6 cols × 4 rows = 24 hours --}}
        <div style="display:grid; grid-template-columns:repeat(6,1fr); gap:4px;">
            @foreach($hourly as $h => $cnt)
            @php
                $opacity = $hMax > 0 && $cnt > 0 ? max(0.12, round($cnt / $hMax, 2)) : 0;
                $bg      = $cnt > 0 ? "rgba(79,70,229,{$opacity})" : '#f1f5f9';
                $textCol = $opacity > 0.5 ? '#fff' : ($cnt > 0 ? '#3730a3' : '#cbd5e1');
            @endphp
            <div title="{{ sprintf('%02d:00', $h) }} — {{ $cnt }} visit{{ $cnt != 1 ? 's' : '' }}"
                 style="background:{{ $bg }}; height:44px; border-radius:6px;
                        display:flex; flex-direction:column; align-items:center; justify-content:center;
                        cursor:default; transition:transform .15s;"
                 onmouseover="this.style.transform='scale(1.12)'"
                 onmouseout="this.style.transform='scale(1)'">
                <span style="font-size:9px; font-weight:700; color:{{ $textCol }}; line-height:1;">{{ sprintf('%02d', $h) }}</span>
                <span style="font-size:8px; color:{{ $textCol }}; opacity:.85; line-height:1.2;">{{ $cnt > 0 ? $cnt : '' }}</span>
            </div>
            @endforeach
        </div>

        {{-- Legend --}}
        <div style="display:flex; align-items:center; gap:6px; margin-top:10px; justify-content:center;">
            <span style="font-size:9px; color:#94a3b8;">Low</span>
            @foreach([0.12, 0.3, 0.5, 0.7, 1.0] as $op)
            <div style="width:14px; height:14px; border-radius:3px; background:rgba(79,70,229,{{ $op }});"></div>
            @endforeach
            <span style="font-size:9px; color:#94a3b8;">High</span>
        </div>
        <p style="font-size:9px; color:#94a3b8; text-align:center; margin-top:4px;">Peak hour ({{ $rangeLabel }}): <strong style="color:#4f46e5;">{{ sprintf('%02d:00', array_search($hMax, $hourly)) }} UTC</strong></p>
    </div>
</div>

{{-- ── Top Pages + ISPs ─────────────────────────────────────────────── --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Top Pages --}}
    <div class="ana-card">
        <h3 class="font-bold text-gray-800 text-sm mb-4 flex items-center gap-2">
            <i class="fas fa-file-alt text-teal-500"></i> Top Pages Visited
        </h3>
        @php $pgMax = $topPages->first()->total ?? 1; @endphp
        <div class="space-y-2">
            @forelse($topPages as $pg)
            @php
                $path = parse_url($pg->page_url, PHP_URL_PATH) ?: '/';
                $query = parse_url($pg->page_url, PHP_URL_QUERY);
                $display = $path . ($query ? '?'.$query : '');
                $pct = round($pg->total / $pgMax * 100);
            @endphp
            <div>
                <div class="flex justify-between text-xs mb-0.5">
                    <span class="font-medium text-gray-700 truncate max-w-[260px]" title="{{ $display }}">{{ $display }}</span>
                    <span class="font-bold text-gray-600 ml-2 flex-shrink-0">{{ number_format($pg->total) }}</span>
                </div>
                <div class="bar-track">
                    <div class="bar-fill bg-teal-400" style="width:{{ max(2,$pct) }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-gray-400 text-xs text-center py-4">No page data yet</p>
            @endforelse
        </div>
    </div>

    {{-- ISPs + Top Cities overall --}}
    <div class="space-y-4">
        {{-- ISPs --}}
        <div class="ana-card">
            <h3 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                <i class="fas fa-network-wired text-rose-500"></i> Top ISP / Networks
            </h3>
            @php $ispMax = $isps->first()->total ?? 1; @endphp
            <div class="space-y-1.5">
                @forelse($isps as $isp)
                @php $pct = round($isp->total / $ispMax * 100); @endphp
                <div class="flex items-center gap-2 text-xs">
                    <span class="truncate flex-1 text-gray-700 font-medium">{{ $isp->isp ?? 'Unknown' }}</span>
                    <div class="w-24 bar-track flex-shrink-0">
                        <div class="bar-fill bg-rose-400" style="width:{{ max(2,$pct) }}%"></div>
                    </div>
                    <span class="w-8 text-right font-bold text-gray-600 flex-shrink-0">{{ $isp->total }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-xs text-center py-2">No data yet</p>
                @endforelse
            </div>
        </div>

        {{-- Top Cities (all countries) --}}
        <div class="ana-card">
            <h3 class="font-bold text-gray-800 text-sm mb-3 flex items-center gap-2">
                <i class="fas fa-map-pin text-violet-500"></i> Top Cities (All Countries)
            </h3>
            @php $tcMax = $topCities->first()->total ?? 1; @endphp
            <div class="space-y-1.5">
                @forelse($topCities->take(8) as $c)
                @php
                    $pct = round($c->total / $tcMax * 100);
                    $flag = '';
                    if ($c->country_code && strlen($c->country_code) === 2) {
                        $chars = str_split(strtoupper($c->country_code));
                        $flag = mb_chr(ord($chars[0]) - ord('A') + 0x1F1E6) . mb_chr(ord($chars[1]) - ord('A') + 0x1F1E6);
                    }
                @endphp
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-base">{{ $flag ?: '🌐' }}</span>
                    <span class="flex-1 font-medium text-gray-700 truncate">{{ $c->city }}, {{ $c->region }}</span>
                    <div class="w-20 bar-track flex-shrink-0">
                        <div class="bar-fill bg-violet-400" style="width:{{ max(2,$pct) }}%"></div>
                    </div>
                    <span class="w-7 text-right font-bold text-gray-600 flex-shrink-0">{{ $c->total }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-xs text-center py-2">No data yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
