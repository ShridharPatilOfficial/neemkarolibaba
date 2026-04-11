@extends('layouts.app')
@section('title', 'Neem Karoli Baba Charitable Trust — Love All, Serve All')
@section('meta_desc', 'Neem Karoli Baba Charitable Trust is a 12A & 80G registered NGO dedicated to feeding the hungry, educating children, and providing healthcare — inspired by the teachings of Maharaj-ji.')
@section('meta_keywords', 'Neem Karoli Baba Charitable Trust, NKB Foundation, NGO India, Maharaj-ji, donate India, 80G charity, food distribution, free education, healthcare NGO, Chandigarh NGO')
@section('canonical', url('/'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "Neem Karoli Baba Charitable Trust",
  "url": "{{ url('/') }}",
  "potentialAction": {
    "@@type": "SearchAction",
    "target": "{{ url('/') }}?s={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════════════
     HERO SLIDER
════════════════════════════════════════════════════════════ --}}
<section class="relative">
    @php
    $defaultSlides = [
        ['url'=>'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=1400&q=80','caption'=>'Serving Humanity With Compassion'],
        ['url'=>'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1400&q=80','caption'=>'Education for Every Child'],
        ['url'=>'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=1400&q=80','caption'=>'Healthcare for All'],
    ];
    $slideItems = $sliders->count()
        ? $sliders->map(fn($s) => ['url' => $s->image_url && !str_starts_with($s->image_url,'http') ? asset('storage/'.$s->image_url) : ($s->image_url ?: $defaultSlides[0]['url']), 'caption' => $s->caption])->toArray()
        : $defaultSlides;
    @endphp

    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach($slideItems as $slide)
            <div class="swiper-slide relative overflow-hidden">

                {{-- Background image --}}
                <img src="{{ $slide['url'] }}" alt="{{ $slide['caption'] }}"
                     class="hero-slide-img absolute inset-0 w-full h-full object-cover">

                {{-- Dark gradient overlay --}}
                <div class="absolute inset-0"
                     style="background: linear-gradient(110deg, rgba(10,5,40,0.88) 0%, rgba(10,5,40,0.60) 45%, rgba(0,0,0,0.15) 100%);"></div>

                {{-- Animated vertical orange border line left --}}
                <div class="hero-border-line absolute left-0 top-0 bottom-0 w-1"
                     style="background: linear-gradient(180deg, transparent, #EA580C, #F97316, transparent);"></div>

                {{-- Bottom accent bar --}}
                <div class="absolute bottom-0 left-0 right-0 h-0.5"
                     style="background: linear-gradient(90deg, #EA580C 0%, #F97316 40%, rgba(249,115,22,0) 100%);"></div>

                {{-- NKB Baba portrait — right side --}}
                <div class="hero-nkb-portrait absolute right-0 bottom-0 h-full hidden lg:flex items-end pointer-events-none"
                     style="width: 38%;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/NeemKaroliBaba.jpg/400px-NeemKaroliBaba.jpg"
                         alt="Neem Karoli Baba"
                         class="h-full max-h-full w-full object-contain object-bottom"
                         style="filter: drop-shadow(-12px 0 40px rgba(0,0,0,0.6)) brightness(0.85) saturate(0.7);"
                         onerror="this.parentElement.style.display='none'">
                    {{-- Gradient fade on left edge of NKB image --}}
                    <div class="absolute inset-0"
                         style="background: linear-gradient(90deg, rgba(10,5,40,0.85) 0%, rgba(10,5,40,0.3) 30%, transparent 60%);"></div>
                </div>

                {{-- Decorative quote chip top-right (desktop) --}}
                <div class="hero-quote-chip absolute top-8 right-8 hidden xl:block max-w-xs"
                     style="z-index:5;">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl px-5 py-4 text-right">
                        <p class="text-orange-300 text-xs font-bold italic leading-relaxed">
                            "Love everyone, serve everyone,<br>remember God, tell the truth."
                        </p>
                        <p class="text-white/50 text-[10px] font-semibold mt-2 uppercase tracking-wider">— Neem Karoli Baba</p>
                    </div>
                </div>

                {{-- Main content --}}
                <div class="absolute inset-0 flex items-center" style="z-index:4;">
                    <div class="px-6 md:px-14 lg:px-20 max-w-2xl">

                        <div class="hero-text-in mb-4">
                            <span class="inline-flex items-center gap-2 bg-orange-600/25 border border-orange-400/50 text-orange-300 text-xs font-bold px-3 py-1.5 rounded-full backdrop-blur-sm tracking-wide">
                                <span class="w-1.5 h-1.5 rounded-full bg-orange-400 animate-pulse"></span>
                                Neem Karoli Baba Charitable Trust
                            </span>
                        </div>

                        <h2 class="hero-text-in text-3xl sm:text-4xl md:text-5xl font-black text-white leading-tight mb-4 drop-shadow-xl">
                            {{ $slide['caption'] }}
                        </h2>

                        <p class="hero-text-in text-gray-300 text-sm md:text-base leading-relaxed mb-7 max-w-md">
                            Inspired by the teachings of Neem Karoli Baba —
                            <em class="text-orange-300 not-italic font-semibold">"Love all, serve all."</em>
                        </p>

                        <div class="hero-text-in flex flex-wrap gap-3">
                            <a href="{{ route('about.founders') }}"
                               class="hero-btn-primary inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 px-6 rounded-lg text-sm transition shadow-xl">
                                About Us <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                            <a href="{{ route('donate') }}"
                               class="hero-btn-secondary inline-flex items-center gap-2 bg-white/12 hover:bg-white/22 border border-white/35 text-white font-bold py-2.5 px-6 rounded-lg text-sm transition backdrop-blur-sm">
                                <i class="fas fa-heart text-orange-400 text-xs"></i> Donate Now
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        {{-- Custom nav arrows --}}
        <div class="swiper-button-prev !text-white !w-10 !h-10 !bg-black/30 !rounded-full backdrop-blur-sm after:!text-sm hover:!bg-orange-600 transition-colors duration-200"
             style="border: 1px solid rgba(255,255,255,0.2);"></div>
        <div class="swiper-button-next !text-white !w-10 !h-10 !bg-black/30 !rounded-full backdrop-blur-sm after:!text-sm hover:!bg-orange-600 transition-colors duration-200"
             style="border: 1px solid rgba(255,255,255,0.2);"></div>

        {{-- Pagination --}}
        <div class="swiper-pagination" style="bottom: 20px;"></div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════
     QUICK STATS BAR
════════════════════════════════════════════════════════════ --}}
@if($impactStats->count())
<div class="bg-purple-900 text-white py-5 px-4">
    <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($impactStats->take(4) as $stat)
        <div class="flex items-center gap-3 justify-center md:justify-start">
            <div class="w-10 h-10 rounded-lg bg-orange-600/30 flex items-center justify-center flex-shrink-0">
                <i class="{{ $stat->icon_class ?: 'fas fa-star' }} text-orange-400"></i>
            </div>
            <div>
                <div class="font-black text-xl text-white leading-none">{{ $stat->number_value }}</div>
                <div class="text-purple-300 text-xs">{{ $stat->label }}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- ════════════════════════════════════════════════════════════
     MISSION / VISION / OBJECTIVES
════════════════════════════════════════════════════════════ --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 reveal">
            <span class="section-tag">Who We Are</span>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-1">Our Core <span class="text-orange-600">Principles</span></h2>
            <p class="text-gray-500 mt-3 max-w-xl mx-auto text-sm leading-relaxed">
                Guided by Maharaj-ji's timeless wisdom — we serve with purpose, vision, and unwavering dedication.
            </p>
        </div>
        @php
            // Delay classes for staggered reveal
            $delayClasses = ['reveal-delay-1','reveal-delay-2','reveal-delay-3','reveal-delay-1','reveal-delay-2','reveal-delay-3'];
            // Fallback cards when DB is empty
            $fallbackPrinciples = collect([
                (object)['icon'=>'fa-dove','color_theme'=>'orange','title'=>'Mission','description'=>'To serve humanity through compassion, education, and healthcare — inspired by Neem Karoli Baba\'s teaching: "Love all, serve all."','link_url'=>null,'theme'=>['gradient'=>'from-orange-500 to-red-500','bg'=>'bg-orange-50']],
                (object)['icon'=>'fa-eye','color_theme'=>'purple','title'=>'Vision','description'=>'A society where every individual, regardless of caste or creed, has access to care, knowledge, and dignity.','link_url'=>null,'theme'=>['gradient'=>'from-purple-600 to-violet-700','bg'=>'bg-purple-50']],
                (object)['icon'=>'fa-bullseye','color_theme'=>'emerald','title'=>'Objectives','description'=>'Free healthcare, education support, community feeding, and interfaith harmony — creating lasting positive impact.','link_url'=>null,'theme'=>['gradient'=>'from-emerald-500 to-teal-600','bg'=>'bg-emerald-50']],
            ]);
            $displayPrinciples = $principles->count() ? $principles : $fallbackPrinciples;
        @endphp
        <div class="grid grid-cols-1 md:grid-cols-{{ min(3, $displayPrinciples->count()) }} gap-6">
            @foreach($displayPrinciples as $i => $card)
            @php $theme = is_array($card->theme) ? $card->theme : (method_exists($card,'getAttribute') ? $card->theme : ['gradient'=>'from-orange-500 to-red-500','bg'=>'bg-orange-50']); @endphp
            <div class="mvision-card {{ $theme['bg'] }} rounded-2xl p-8 border border-gray-100 reveal {{ $delayClasses[$i % 3] ?? '' }}">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center mb-5 shadow-lg">
                    <i class="fas {{ $card->icon }} text-white text-xl"></i>
                </div>
                <h3 class="font-bold text-xl text-gray-900 mb-3">{{ $card->title }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed">{{ $card->description }}</p>
                <a href="{{ $card->link_url ?: route('about.founders') }}" class="inline-flex items-center gap-2 mt-5 text-orange-600 font-semibold text-sm hover:gap-3 transition-all">
                    Learn More <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════
     ABOUT / WELCOME
════════════════════════════════════════════════════════════ --}}
<section class="py-20 px-4 overflow-hidden" style="background:linear-gradient(135deg, #fafafa 0%, #f3f0ff 100%);">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        {{-- Image side --}}
        <div class="relative flex justify-center reveal">
            {{-- Decorative blobs --}}
            <div class="absolute -top-8 -left-8 w-64 h-64 bg-orange-100 rounded-full -z-10 blur-3xl opacity-60"></div>
            <div class="absolute -bottom-8 -right-8 w-48 h-48 bg-purple-100 rounded-full -z-10 blur-2xl opacity-70"></div>

            <div class="relative w-72 md:w-80">
                {{-- Background card --}}
                <div class="absolute top-6 left-6 w-full h-full bg-gradient-to-br from-orange-400 to-orange-600 rounded-3xl"></div>
                {{-- Main image --}}
                <div class="relative bg-white rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/NeemKaroliBaba.jpg/400px-NeemKaroliBaba.jpg"
                         alt="Neem Karoli Baba" class="w-full h-96 object-cover"
                         onerror="this.src='https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&q=80'">
                </div>
                {{-- Badge --}}
                <div class="absolute -bottom-4 -right-4 bg-purple-900 text-white rounded-2xl px-4 py-3 shadow-xl text-center">
                    <p class="font-black text-2xl text-orange-400">50+</p>
                    <p class="text-xs font-semibold text-purple-200">Years of<br>Legacy</p>
                </div>
            </div>
        </div>

        {{-- Text side --}}
        <div class="reveal reveal-delay-2">
            <span class="section-tag">Welcome To Our Foundation</span>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 leading-tight mt-1 mb-5">
                Serving Communities,<br><span class="text-orange-600">Transforming Lives</span>
            </h2>

            <div class="flex items-start gap-3 bg-orange-50 border-l-4 border-orange-500 rounded-r-xl p-4 mb-6">
                <i class="fas fa-quote-left text-orange-300 text-2xl mt-1 flex-shrink-0"></i>
                <p class="text-gray-700 italic text-sm leading-relaxed">
                    "Love everyone, serve everyone, remember God, tell the truth."<br>
                    <span class="not-italic font-bold text-orange-600">— Neem Karoli Baba (Maharaj-ji)</span>
                </p>
            </div>

            <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                {{ $settings['about_text'] ?? 'The Neem Karoli Baba Charitable Trust is a registered non-profit inspired by the life and teachings of the revered saint Neem Karoli Baba. Rooted in the values of selfless service and unconditional love, we work across North India to uplift communities through healthcare, education, and humanitarian aid.' }}
            </p>

            <div class="grid grid-cols-2 gap-3 mb-7">
                @foreach(['Healthcare Welfare','Education Support','Food Distribution','Women Empowerment'] as $item)
                <div class="flex items-center gap-2 text-gray-700 text-sm font-medium bg-white rounded-lg p-3 border border-gray-100 shadow-sm">
                    <span class="w-5 h-5 rounded-full bg-orange-600 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-check text-white text-[9px]"></i>
                    </span>
                    {{ $item }}
                </div>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('about.founders') }}"
                   class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-bold py-3 px-7 rounded-xl transition shadow-lg">
                    Learn More <i class="fas fa-arrow-right"></i>
                </a>
                <a href="{{ route('activities') }}"
                   class="inline-flex items-center gap-2 border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-bold py-3 px-7 rounded-xl transition">
                    Our Activities
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ════════════════════════════════════════════════════════════
     IMPACT STATS (full width, dark)
════════════════════════════════════════════════════════════ --}}
@if($impactStats->count())
<section class="py-20 px-4 relative overflow-hidden"
         style="background: linear-gradient(135deg, #1e1b4b 0%, #2d2571 50%, #1e1b4b 100%);">
    {{-- Decorative circles --}}
    <div class="absolute top-0 left-0 w-80 h-80 rounded-full bg-orange-600/10 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 rounded-full bg-purple-600/20 translate-x-1/3 translate-y-1/3"></div>
    <div class="absolute inset-0 opacity-5">
        <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1400&q=80" alt="" class="w-full h-full object-cover">
    </div>

    <div class="max-w-7xl mx-auto relative">
        <div class="text-center mb-14 reveal">
            <span class="section-tag" style="color:#f97316">Our Impact</span>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-1">
                Numbers That <span class="text-orange-400">Tell Our Story</span>
            </h2>
            <p class="text-purple-300 mt-3 text-sm">Every number represents a life touched, a family served, a community uplifted.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($impactStats as $stat)
            <div class="stat-card bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-6 text-center reveal hover:bg-white/15 transition">
                <div class="w-14 h-14 rounded-xl bg-orange-600/30 border border-orange-500/40 flex items-center justify-center mx-auto mb-4">
                    <i class="{{ $stat->icon_class ?: 'fas fa-star' }} text-orange-400 text-xl"></i>
                </div>
                <div class="text-4xl font-black text-white mb-1 counter-num"
                     data-target="{{ preg_replace('/\D/', '', $stat->number_value) }}">
                    {{ $stat->number_value }}
                </div>
                <div class="text-purple-300 text-sm font-medium">{{ $stat->label }}</div>
            </div>
            @endforeach
        </div>

        {{-- CTA inside stats --}}
        <div class="text-center mt-12 reveal">
            <p class="text-purple-200 text-sm mb-4 italic">"If you want to see the change, be the change."</p>
            <a href="{{ route('donate') }}"
               class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3.5 px-8 rounded-xl transition shadow-xl">
                <i class="fas fa-heart-pulse"></i> Support Our Cause
            </a>
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     RECENT ACTIVITIES
════════════════════════════════════════════════════════════ --}}
@if($recentActivities->count())
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div class="reveal">
                <span class="section-tag">What We Do</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-1">
                    Recent <span class="text-orange-600">Activities</span>
                </h2>
                <p class="text-gray-500 text-sm mt-2 max-w-lg">Fostering positive and everlasting change — uplifting lives, one act of service at a time.</p>
            </div>
            <a href="{{ route('activities') }}"
               class="inline-flex items-center gap-2 border-2 border-purple-900 text-purple-900 hover:bg-purple-900 hover:text-white font-bold py-2.5 px-6 rounded-xl transition text-sm flex-shrink-0 reveal">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
            @foreach($recentActivities as $i => $activity)
            @php
                $img = $activity->image_url ? (str_starts_with($activity->image_url, 'http') ? $activity->image_url : asset('storage/' . $activity->image_url)) : null;
                if(!$img && $activity->youtube_url) {
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $activity->youtube_url, $ym);
                    $ytId = $ym[1] ?? null;
                    $img = $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : null;
                }
            @endphp
            <div class="card-hover bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm reveal reveal-delay-{{ $i%3+1 }}">
                <div class="img-zoom h-52 bg-gray-100">
                    @if($img)
                    <img src="{{ $img }}" alt="{{ $activity->heading }}" class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full bg-gradient-to-br from-purple-100 to-orange-50 flex items-center justify-center">
                        <i class="fas fa-hands-helping text-purple-300 text-5xl"></i>
                    </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                        <span class="text-orange-600 text-xs font-semibold uppercase tracking-wider">Activity</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2 leading-snug">{{ $activity->heading }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed line-clamp-2">{{ $activity->description }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif


{{-- ════════════════════════════════════════════════════════════
     COLLABORATED PARTNERS
════════════════════════════════════════════════════════════ --}}
@if($partners->count())
<section class="py-16 px-4 bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10 reveal">
            <span class="section-tag">Collaborations</span>
            <h2 class="text-2xl md:text-3xl font-black text-gray-900 mt-1">Our <span class="text-orange-600">Partner Organisations</span></h2>
            <p class="text-gray-500 text-sm mt-2">Trusted partners who continuously support our mission</p>
        </div>
        <div class="swiper partners-swiper reveal">
            <div class="swiper-wrapper items-center">
                @foreach($partners as $partner)
                <div class="swiper-slide px-3">
                    @if($partner->website_url)
                    <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer"
                       class="partner-card rounded-2xl block cursor-pointer" title="{{ $partner->name }}">
                    @else
                    <div class="partner-card rounded-2xl">
                    @endif
                        <img src="{{ $partner->logo_url && !str_starts_with($partner->logo_url, 'http') ? asset('storage/' . $partner->logo_url) : $partner->logo_url }}"
                             alt="{{ $partner->name }}">
                    @if($partner->website_url)
                    </a>
                    @else
                    </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     EVENTS
════════════════════════════════════════════════════════════ --}}
@if($events->count())
<section class="py-20 px-4" style="background:linear-gradient(135deg,#fafafa 0%,#f0ebff 100%);">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div class="reveal">
                <span class="section-tag">Upcoming & Recent</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-1">
                    Events We <span class="text-orange-600">Organise</span>
                </h2>
                <p class="text-gray-500 text-sm mt-2">Celebrations, programs, and drives that bring community together.</p>
            </div>
            <a href="{{ route('events') }}"
               class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-xl transition text-sm flex-shrink-0 reveal">
                All Events <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($events as $i => $event)
            @php
                $eventImg = $event->image_url ? (str_starts_with($event->image_url,'http') ? $event->image_url : asset('storage/'.$event->image_url)) : 'https://picsum.photos/400/250?random='.$event->id;
            @endphp
            <div class="card-hover bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 reveal reveal-delay-{{ $i%4+1 }}">
                <div class="img-zoom h-44 relative">
                    <img src="{{ $eventImg }}" alt="{{ $event->heading }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                </div>
                <div class="p-4">
                    <div class="flex items-center gap-2 mb-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                        <span class="text-purple-600 text-xs font-semibold uppercase tracking-wider">Event</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2">{{ $event->heading }}</h3>
                    <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 mb-3">{{ $event->description }}</p>
                    <a href="{{ route('events') }}" class="inline-flex items-center gap-1 text-orange-600 font-semibold text-xs hover:gap-2 transition-all">
                        Read More <i class="fas fa-arrow-right text-[9px]"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     PRESIDENT MESSAGE
════════════════════════════════════════════════════════════ --}}
@if($presidentMessage)
<section class="py-16 md:py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10 reveal">
            <span class="section-tag">Leadership</span>
            <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-1">
                President's <span class="text-orange-600">Message</span>
            </h2>
            <p class="text-gray-500 text-sm mt-2">Dedicated personality striving to foster unity, compassion and success</p>
        </div>

        <div class="bg-gradient-to-br from-purple-950 to-purple-900 rounded-3xl overflow-hidden shadow-2xl reveal"
             style="box-shadow: 0 32px 80px rgba(76,29,149,0.25);">
            <div class="flex flex-col lg:flex-row">

                {{-- Left profile panel --}}
                <div class="lg:w-80 flex-shrink-0 relative bg-gradient-to-br from-orange-500 to-orange-700 p-8 flex flex-col items-center justify-center text-center"
                     style="background-image: radial-gradient(circle at 50% 50%, rgba(255,255,255,0.08) 1px, transparent 1px); background-size: 20px 20px;">

                    {{-- Profile Photo --}}
                    <div class="relative mb-5">
                        @if($presidentMessage->photo_url)
                        <img src="{{ str_starts_with($presidentMessage->photo_url, 'http') ? $presidentMessage->photo_url : asset('storage/' . $presidentMessage->photo_url) }}"
                             alt="{{ $presidentMessage->president_name }}"
                             class="w-32 h-32 rounded-full object-cover border-4 border-white/60 shadow-2xl mx-auto">
                        @else
                        <div class="w-32 h-32 rounded-full bg-white/20 border-4 border-white/40 flex items-center justify-center mx-auto overflow-hidden">
                            <i class="fas fa-user text-white/50 text-5xl mt-5"></i>
                        </div>
                        @endif
                        {{-- Online indicator --}}
                        <span class="absolute bottom-1 right-1 w-5 h-5 rounded-full bg-green-400 border-2 border-white shadow"></span>
                    </div>

                    {{-- Name & Title --}}
                    <h3 class="font-black text-white text-xl leading-tight mb-1">
                        {{ $presidentMessage->president_name }}
                    </h3>
                    <p class="text-orange-100 text-sm font-medium mb-5 leading-snug">
                        {{ $presidentMessage->president_title }}
                    </p>

                    {{-- Signature --}}
                    @if($presidentMessage->signature_url)
                    <div class="bg-white/15 rounded-xl p-3 w-full">
                        <p class="text-white/50 text-[10px] uppercase tracking-widest mb-2 font-semibold">Signature</p>
                        <img src="{{ str_starts_with($presidentMessage->signature_url,'http') ? $presidentMessage->signature_url : asset('storage/'.$presidentMessage->signature_url) }}"
                             alt="Signature"
                             class="h-14 mx-auto object-contain drop-shadow-lg">
                    </div>
                    @else
                    <div class="bg-white/10 rounded-xl px-4 py-2">
                        <p class="text-orange-200 text-xs font-medium italic">{{ $presidentMessage->president_name }}</p>
                        <div class="h-px bg-white/30 mt-1"></div>
                    </div>
                    @endif
                </div>

                {{-- Right message panel --}}
                <div class="flex-1 p-6 sm:p-8 md:p-12 flex flex-col justify-between">
                    {{-- Quote mark --}}
                    <div class="text-8xl text-orange-500/20 font-serif leading-none select-none -mt-2 mb-2">&ldquo;</div>

                    {{-- Message text --}}
                    <p class="text-gray-200 leading-relaxed text-sm sm:text-base md:text-lg italic whitespace-pre-line flex-1">
                        {{ $presidentMessage->message }}
                    </p>

                    {{-- Footer divider --}}
                    <div class="mt-8 pt-6 border-t border-purple-700/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-orange-600/30 border border-orange-500/40 flex items-center justify-center">
                                <i class="fas fa-om text-orange-400"></i>
                            </div>
                            <div>
                                <p class="text-white font-bold text-sm">{{ $presidentMessage->president_name }}</p>
                                <p class="text-purple-300 text-xs">{{ $presidentMessage->president_title }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="h-px w-12 bg-orange-500/50"></div>
                            <span class="text-orange-400 font-bold text-sm italic">Jai Ram Ji Ki</span>
                            <div class="h-px w-12 bg-orange-500/50"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- ════════════════════════════════════════════════════════════
     WORK IN ACTION — VIDEO CARDS
════════════════════════════════════════════════════════════ --}}
<section class="py-20 px-4" style="background:linear-gradient(135deg,#0a0528 0%,#1e0a3c 100%);">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 reveal">
            <div class="inline-flex items-center gap-2 mb-3">
                <div class="h-px w-10 bg-orange-500"></div>
                <span class="text-orange-400 text-xs font-bold uppercase tracking-widest">Watch &amp; Learn</span>
                <div class="h-px w-10 bg-orange-500"></div>
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-white mt-1">
                See Our <span class="text-orange-400">Work in Action</span>
            </h2>
            <p class="text-purple-300 mt-3 max-w-xl mx-auto text-sm leading-relaxed">
                Real moments, real lives changed — watch our programmes and drives on the ground.
            </p>
        </div>

        @if($workVideos->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($workVideos as $i => $vid)
            @php $ytId = $vid->youtube_id; @endphp
            <div class="work-video-card group relative bg-gray-900 rounded-2xl overflow-hidden shadow-lg border border-white/10
                        hover:border-orange-500/50 hover:-translate-y-2 hover:shadow-orange-900/40 hover:shadow-2xl
                        transition-all duration-400 cursor-pointer reveal reveal-delay-{{ $i % 4 + 1 }}"
                 onclick="openWorkVideo('{{ $ytId }}','{{ addslashes($vid->title) }}')">

                <div class="relative overflow-hidden h-44">
                    <img src="{{ $ytId ? 'https://img.youtube.com/vi/'.$ytId.'/maxresdefault.jpg' : 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=600&q=80' }}"
                         alt="{{ $vid->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                         onerror="this.src='https://img.youtube.com/vi/{{ $ytId }}/mqdefault.jpg'">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-14 h-14 rounded-full bg-red-600 group-hover:bg-red-500 group-hover:scale-110
                                    flex items-center justify-center shadow-2xl transition-all duration-300
                                    ring-4 ring-red-600/30 group-hover:ring-red-500/50">
                            <i class="fas fa-play text-white text-base ml-1"></i>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-lg flex items-center gap-1">
                            <i class="fab fa-youtube text-xs"></i> YouTube
                        </span>
                    </div>
                </div>

                <div class="p-4">
                    <h3 class="text-white font-bold text-sm leading-snug mb-1.5 line-clamp-2 group-hover:text-orange-300 transition-colors">
                        {{ $vid->title }}
                    </h3>
                    @if($vid->description)
                    <p class="text-gray-400 text-xs leading-relaxed line-clamp-2">{{ $vid->description }}</p>
                    @endif
                    <div class="mt-3 flex items-center gap-1.5 text-orange-400 text-xs font-semibold">
                        <i class="fas fa-play-circle text-sm"></i> Watch Now
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Empty state — shown until admin adds videos --}}
        <div class="text-center py-16 reveal">
            <div class="w-20 h-20 rounded-full bg-white/10 border border-white/20 flex items-center justify-center mx-auto mb-5">
                <i class="fab fa-youtube text-red-400 text-3xl"></i>
            </div>
            <p class="text-purple-300 text-base font-semibold mb-2">Videos coming soon!</p>
            <p class="text-purple-400 text-sm">Our team is uploading programme videos. Check back shortly.</p>
        </div>
        @endif

        <div class="text-center mt-10 reveal">
            <a href="{{ route('gallery') }}"
               class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/20 border border-white/20 text-white font-bold py-3 px-8 rounded-xl transition backdrop-blur-sm text-sm">
                <i class="fas fa-photo-film"></i> View Full Gallery
            </a>
        </div>
    </div>
</section>

{{-- Work Video Modal --}}
<div id="workVideoModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,0.93);backdrop-filter:blur(8px);">
    <button onclick="closeWorkVideo()"
            class="absolute top-4 right-5 text-white/70 hover:text-white z-10 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
        <i class="fas fa-times text-lg"></i>
    </button>
    <div class="bg-gray-950 rounded-3xl overflow-hidden shadow-2xl w-full max-w-4xl" onclick="event.stopPropagation()">
        <div class="relative bg-black" style="padding-bottom:56.25%">
            <iframe id="workVideoFrame" src="" class="absolute inset-0 w-full h-full"
                    frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="p-5 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-red-600/20 flex items-center justify-center flex-shrink-0">
                <i class="fab fa-youtube text-red-400 text-sm"></i>
            </div>
            <p id="workVideoTitle" class="text-white font-bold text-sm"></p>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     MEDIA COVERAGE — HOME PREVIEW
════════════════════════════════════════════════════════════ --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div class="text-center md:text-left reveal">
                <span class="section-tag">Press &amp; Media</span>
                <h2 class="text-3xl md:text-4xl font-black text-gray-900 mt-1">
                    Featured In <span class="text-orange-600">Media</span>
                </h2>
                <p class="text-gray-500 text-sm mt-2">News channels, TV, and online media coverage of our work</p>
            </div>
            <a href="{{ route('media-coverage') }}"
               class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-xl transition text-sm flex-shrink-0 reveal">
                All Coverage <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if($mediaCoverages->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($mediaCoverages as $i => $cov)
            @php
                $img = $cov->cover_image_url ? (str_starts_with($cov->cover_image_url,'http') ? $cov->cover_image_url : asset('storage/'.$cov->cover_image_url)) : null;
                if (!$img && $cov->youtube_id) $img = 'https://img.youtube.com/vi/'.$cov->youtube_id.'/maxresdefault.jpg';
                if (!$img) $img = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600&q=80';
                $catColor = ['news'=>'bg-blue-600','tv'=>'bg-red-600','online'=>'bg-green-600','magazine'=>'bg-purple-600'][$cov->category] ?? 'bg-gray-600';
                $catLabel = \App\Models\MediaCoverage::categories()[$cov->category] ?? 'News';
            @endphp
            <div class="group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100
                        hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col reveal reveal-delay-{{ $i % 3 + 1 }}">
                {{-- Image --}}
                <div class="relative overflow-hidden h-48 bg-gray-100">
                    <img src="{{ $img }}" alt="{{ $cov->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <span class="absolute top-3 left-3 {{ $catColor }} text-white text-[10px] font-bold px-2 py-1 rounded-full">
                        {{ $catLabel }}
                    </span>
                    <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
                        <span class="bg-black/60 text-white text-[10px] font-semibold px-2 py-1 rounded-lg">
                            <i class="fas fa-broadcast-tower text-orange-400 mr-1"></i>{{ $cov->source_name }}
                        </span>
                        @if($cov->published_date)
                        <span class="bg-black/60 text-white text-[10px] px-2 py-1 rounded-lg">
                            {{ $cov->published_date->format('d M Y') }}
                        </span>
                        @endif
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2 line-clamp-2">{{ $cov->title }}</h3>
                    @if($cov->description)
                    <p class="text-gray-500 text-xs leading-relaxed line-clamp-2 mb-4 flex-1">{{ $cov->description }}</p>
                    @else
                    <div class="flex-1"></div>
                    @endif
                    <div class="flex items-center gap-2 mt-auto pt-3 border-t border-gray-100 flex-wrap">
                        @if($cov->youtube_id)
                        <button onclick="openHomeMediaVideo('{{ $cov->youtube_id }}','{{ addslashes($cov->title) }}')"
                                class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                            <i class="fab fa-youtube text-xs"></i> Watch
                        </button>
                        @endif
                        @if($cov->source_url)
                        <a href="{{ $cov->source_url }}" target="_blank" rel="noopener"
                           class="inline-flex items-center gap-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                            <i class="fas fa-external-link-alt text-xs"></i> Read Article
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        {{-- Empty state --}}
        <div class="text-center py-16 reveal">
            <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-5">
                <i class="fas fa-newspaper text-orange-400 text-3xl"></i>
            </div>
            <p class="text-gray-700 text-base font-semibold mb-2">Media coverage coming soon!</p>
            <p class="text-gray-400 text-sm">We'll share news and media features about our work here.</p>
        </div>
        @endif
    </div>
</section>

{{-- Home Media Video Modal --}}
<div id="homeMediaModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,0.93);backdrop-filter:blur(8px);">
    <button onclick="closeHomeMediaVideo()"
            class="absolute top-4 right-5 text-white/70 hover:text-white z-10 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center transition">
        <i class="fas fa-times text-lg"></i>
    </button>
    <div class="bg-gray-950 rounded-3xl overflow-hidden shadow-2xl w-full max-w-4xl" onclick="event.stopPropagation()">
        <div class="relative bg-black" style="padding-bottom:56.25%">
            <iframe id="homeMediaFrame" src="" class="absolute inset-0 w-full h-full"
                    frameborder="0" allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="p-5 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-red-600/20 flex items-center justify-center flex-shrink-0">
                <i class="fab fa-youtube text-red-400 text-sm"></i>
            </div>
            <p id="homeMediaTitle" class="text-white font-bold text-sm"></p>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════════════════════════
     DONATE CTA RIBBON
════════════════════════════════════════════════════════════ --}}
<section class="donate-ribbon relative overflow-hidden">
    {{-- Neem Karoli Baba image — left side --}}
    <div class="absolute left-0 bottom-0 h-full flex items-end pointer-events-none select-none hidden md:flex"
         style="z-index:1;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/NeemKaroliBaba.jpg/400px-NeemKaroliBaba.jpg"
             alt="Neem Karoli Baba"
             class="h-full max-h-72 w-auto object-contain object-bottom"
             style="filter: drop-shadow(0 0 30px rgba(0,0,0,0.4)) brightness(0.92);"
             onerror="this.style.display='none'">
    </div>

    {{-- Neem Karoli Baba image — right side (mirrored) --}}
    <div class="absolute right-0 bottom-0 h-full flex items-end pointer-events-none select-none hidden md:flex"
         style="z-index:1;">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/NeemKaroliBaba.jpg/400px-NeemKaroliBaba.jpg"
             alt="Neem Karoli Baba"
             class="h-full max-h-72 w-auto object-contain object-bottom"
             style="filter: drop-shadow(0 0 30px rgba(0,0,0,0.4)) brightness(0.92); transform: scaleX(-1);"
             onerror="this.style.display='none'">
    </div>

    {{-- Soft radial glow behind text --}}
    <div class="absolute inset-0 flex items-center justify-center pointer-events-none" style="z-index:1;">
        <div class="w-96 h-48 rounded-full" style="background: radial-gradient(ellipse, rgba(0,0,0,0.25) 0%, transparent 70%);"></div>
    </div>

    {{-- Content --}}
    <div class="relative max-w-2xl mx-auto text-center px-4 py-14 md:py-16" style="z-index:2;">
        <div class="reveal">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-full bg-white/20 border border-white/30 mb-5">
                <i class="fas fa-hands-holding-heart text-white text-xl"></i>
            </div>
            <h2 class="text-3xl md:text-4xl font-black text-white mb-3 drop-shadow-lg">
                Be the Change — Donate Today
            </h2>
            <p class="text-orange-100 text-sm mb-7 max-w-md mx-auto leading-relaxed drop-shadow">
                Your generosity funds education, healthcare, and community feeding programmes.
                All donations are tax-exempt under Section 80G.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('donate') }}"
                   class="inline-flex items-center gap-2 bg-white text-orange-600 hover:bg-orange-50 font-bold py-3.5 px-8 rounded-xl transition shadow-xl">
                    <i class="fas fa-heart-pulse"></i> Donate Now
                </a>
                <a href="{{ route('join-us') }}"
                   class="inline-flex items-center gap-2 bg-white/15 hover:bg-white/25 border border-white/40 text-white font-bold py-3.5 px-8 rounded-xl transition backdrop-blur-sm">
                    <i class="fas fa-user-plus"></i> Join Us
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
// Hero slider — creative effect with slide + fade combo
new Swiper('.hero-swiper', {
    loop: true,
    effect: 'creative',
    creativeEffect: {
        prev:  { shadow: true,  translate: ['-105%', 0, -500], opacity: 0 },
        next:  { translate: ['105%', 0, 0], opacity: 0.5 },
    },
    autoplay: { delay: 5500, disableOnInteraction: false },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: function(index, cls) {
            return `<span class="${cls}" style="width:8px;height:8px;background:rgba(255,255,255,0.5);border-radius:4px;transition:all 0.3s;"></span>`;
        },
    },
    speed: 800,
    on: {
        slideChangeTransitionStart: function() {
            // Re-trigger CSS animations by cloning active slide's animated children
            const active = this.slides[this.activeIndex];
            if (!active) return;
            active.querySelectorAll('.hero-text-in, .hero-nkb-portrait, .hero-quote-chip, .hero-border-line').forEach(el => {
                el.style.animation = 'none';
                el.offsetHeight; // reflow
                el.style.animation = '';
            });
        }
    }
});

// Partners carousel
@if(isset($partners) && $partners->count())
new Swiper('.partners-swiper', {
    loop: true,
    autoplay: { delay: 2500, disableOnInteraction: false },
    slidesPerView: 2,
    spaceBetween: 16,
    breakpoints: {
        480:  { slidesPerView: 3, spaceBetween: 20 },
        768:  { slidesPerView: 4, spaceBetween: 24 },
        1024: { slidesPerView: 5, spaceBetween: 24 },
    },
});
@endif

// ── Work in Action video modal ──────────────────────────────
function openWorkVideo(ytId, title) {
    if (!ytId) return;
    document.getElementById('workVideoFrame').src =
        'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0&modestbranding=1';
    document.getElementById('workVideoTitle').textContent = title || '';
    const m = document.getElementById('workVideoModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeWorkVideo() {
    document.getElementById('workVideoFrame').src = '';
    const m = document.getElementById('workVideoModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}
const wvm = document.getElementById('workVideoModal');
if (wvm) {
    wvm.addEventListener('click', function(e) { if (e.target === this) closeWorkVideo(); });
}

// ── Home Media Coverage video modal ────────────────────────
function openHomeMediaVideo(ytId, title) {
    document.getElementById('homeMediaFrame').src =
        'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0&modestbranding=1';
    document.getElementById('homeMediaTitle').textContent = title || '';
    const m = document.getElementById('homeMediaModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeHomeMediaVideo() {
    document.getElementById('homeMediaFrame').src = '';
    const m = document.getElementById('homeMediaModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    document.body.style.overflow = '';
}
const hmm = document.getElementById('homeMediaModal');
if (hmm) {
    hmm.addEventListener('click', function(e) { if (e.target === this) closeHomeMediaVideo(); });
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') { closeWorkVideo(); closeHomeMediaVideo(); }
});
</script>
@endpush
