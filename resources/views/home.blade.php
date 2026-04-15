@extends('layouts.app')
@section('title', $siteName.' — Love All, Serve All')
@section('meta_desc', $siteName.' is a 12A & 80G registered NGO dedicated to feeding the hungry, educating children, and providing healthcare — inspired by the teachings of Maharaj-ji.')
@section('meta_keywords', $siteName.', NKB Foundation, NGO India, Maharaj-ji, donate India, 80G charity, food distribution, free education, healthcare NGO, Chandigarh NGO')
@section('canonical', url('/'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebSite",
  "name": "{{ $siteName }}",
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

{{-- ════════ HERO SLIDER ════════════════════════════════════════════ --}}
<section class="relative hero-redesign">
    @php
    $defaultSlides = [
        ['url'=>'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=1400&q=80','caption'=>'Serving Humanity<br><em>With Compassion</em>'],
        ['url'=>'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=1400&q=80','caption'=>'Education for<br><em>Every Child</em>'],
        ['url'=>'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=1400&q=80','caption'=>'Healthcare<br><em>for All</em>'],
    ];
    $slideItems = $sliders->count()
        ? $sliders->map(fn($s) => ['url' => $s->image_url && !str_starts_with($s->image_url,'http') ? asset('storage/'.$s->image_url) : ($s->image_url ?: $defaultSlides[0]['url']), 'caption' => $s->caption])->toArray()
        : $defaultSlides;
    @endphp

    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach($slideItems as $i => $slide)
            <div class="swiper-slide relative overflow-hidden hero-slide-wrap">

                {{-- Background --}}
                <img src="{{ $slide['url'] }}" alt="{{ strip_tags($slide['caption']) }}"
                     class="hero-slide-img absolute inset-0 w-full h-full object-cover">

                {{-- New dark overlay --}}
                <div class="hero-overlay-new absolute inset-0"></div>

                {{-- Maharaj-ji portrait right --}}
                <div class="hero-nkb-portrait absolute right-0 bottom-0 h-full hidden lg:flex items-end pointer-events-none"
                     style="width:36%; z-index:3;">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/NeemKaroliBaba.jpg/400px-NeemKaroliBaba.jpg"
                         alt="Neem Karoli Baba"
                         class="h-full max-h-full w-full object-contain object-bottom"
                         style="filter:drop-shadow(-12px 0 40px rgba(0,0,0,.6)) brightness(.85) saturate(.7);"
                         onerror="this.parentElement.style.display='none'">
                    <div class="absolute inset-0"
                         style="background:linear-gradient(90deg,rgba(8,5,25,.88) 0%,rgba(8,5,25,.28) 30%,transparent 62%);"></div>
                </div>

                {{-- Accent line left --}}
                <div class="absolute left-0 top-0 bottom-0 w-1"
                     style="background:linear-gradient(180deg,transparent,#F97316,#FCD34D,transparent); z-index:4;"></div>

                {{-- Bottom accent --}}
                <div class="absolute bottom-0 left-0 right-0 h-px"
                     style="background:linear-gradient(90deg,#F97316,rgba(249,115,22,0)); z-index:4;"></div>

                {{-- Quote chip top-right --}}
                <div class="hero-quote-chip absolute top-8 right-8 hidden xl:block max-w-xs" style="z-index:5;">
                    <div class="bg-white/8 backdrop-blur-md border border-white/15 rounded-2xl px-5 py-4 text-right">
                        <p class="text-orange-300 text-xs font-bold italic leading-relaxed">
                            "Love everyone, serve everyone,<br>remember God, tell the truth."
                        </p>
                        <p class="text-white/45 text-[10px] font-semibold mt-2 uppercase tracking-wider">— Neem Karoli Baba</p>
                    </div>
                </div>

                {{-- Bottom bar: eyebrow + title only --}}
                <div class="hero-bottom-bar" style="z-index:4;">
                    <div class="hbb-left hero-text-in" style="max-width:100%;flex:1;">
                        <span class="hero-eyebrow" style="margin-bottom:.5rem;">
                            <span class="dot"></span>
                            {{ $siteName }}
                        </span>
                        <h2 class="hero-title-new" style="margin-bottom:0;">
                            {!! $slide['caption'] !!}
                        </h2>
                    </div>
                </div>

                {{-- Scroll hint --}}
                <div class="hero-scroll" style="z-index:5;">
                    <div class="hero-scroll-line"></div>
                </div>

            </div>
            @endforeach
        </div>

        <div class="swiper-button-prev !text-white !w-14 !h-14 !bg-black/40 !rounded-full backdrop-blur-sm after:!text-base hover:!bg-orange-600 transition-all duration-300"
             style="border:1.5px solid rgba(255,255,255,.28);box-shadow:0 4px 20px rgba(0,0,0,.35);"></div>
        <div class="swiper-button-next !text-white !w-14 !h-14 !bg-black/40 !rounded-full backdrop-blur-sm after:!text-base hover:!bg-orange-600 transition-all duration-300"
             style="border:1.5px solid rgba(255,255,255,.28);box-shadow:0 4px 20px rgba(0,0,0,.35);"></div>
        <div class="swiper-pagination" style="bottom:20px;"></div>
    </div>
</section>

{{-- ════════ STATS STRIP ═══════════════════════════════════════════ --}}
@if($impactStats->count())
<div class="stats-strip">
    <div class="max-w-7xl mx-auto px-4">
        <div class="ss-grid">
            @foreach($impactStats->take(4) as $stat)
            <div class="ss-item">
                <div class="ss-icon">
                    <i class="{{ $stat->icon_class ?: 'fas fa-star' }}"></i>
                </div>
                <div>
                    <div class="ss-num counter-num" data-target="{{ preg_replace('/\D/','',$stat->number_value) }}">
                        {{ $stat->number_value }}
                    </div>
                    <div class="ss-lbl">{{ $stat->label }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ════════ MISSION / VISION / OBJECTIVES ════════════════════════ --}}
<section class="py-20 px-4" style="background:#FFFBF5;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 reveal">
            <span class="sec-eyebrow">Who We Are</span>
            <h2 class="sec-h2 mt-2">Our Core <span class="hl">Principles</span></h2>
            <p class="sec-sub max-w-xl mx-auto mt-3">
                Illuminated by Maharaj-ji's timeless grace, we walk a path of purposeful service, bound by vision and steadfast dedication.
            </p>
        </div>

        @php
            $pcThemes = [
                ['orange', 'from-orange-500 to-red-500', 'bg-orange-50'],
                ['purple', 'from-purple-600 to-violet-700', 'bg-purple-50'],
                ['emerald', 'from-emerald-500 to-teal-600', 'bg-emerald-50'],
            ];
            $fallbackPrinciples = collect([
                (object)['icon'=>'fa-dove','color_theme'=>'orange','title'=>'Mission','description'=>"To serve humanity through compassion, education, and healthcare — inspired by Neem Karoli Baba's teaching: \"Love all, serve all.\"",'link_url'=>route('about.objectives')],
                (object)['icon'=>'fa-eye','color_theme'=>'purple','title'=>'Vision','description'=>'A society where every individual, regardless of caste or creed, has access to care, knowledge, and dignity.','link_url'=>route('about.objectives')],
                (object)['icon'=>'fa-bullseye','color_theme'=>'emerald','title'=>'Objectives','description'=>'Free healthcare, education support, community feeding, and interfaith harmony — creating lasting positive impact.','link_url'=>route('about.objectives')],
            ]);
            $displayPrinciples = $principles->count() ? $principles : $fallbackPrinciples;
        @endphp

        <div class="principle-cards">
            @foreach($displayPrinciples as $i => $card)
            @php
                $t = $pcThemes[$i % 3];
                $colorName = $t[0];
            @endphp
            <div class="pc-card pc-card-{{ $colorName }} reveal reveal-delay-{{ $i % 3 + 1 }}">
                <div class="pc-icon-wrap pc-icon-wrap-{{ $colorName }}">
                    <i class="fas {{ $card->icon }}"></i>
                </div>
                <h3 class="pc-title">{{ $card->title }}</h3>
                <div class="pc-desc rich-text">{!! $card->description !!}</div>
                <a href="{{ $card->link_url ?? route('about.objectives') }}" class="pc-link pc-link-{{ $colorName }}">
                    Learn More <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ════════ ABOUT / WELCOME ═══════════════════════════════════════ --}}
<section class="py-20 px-4 overflow-hidden bg-white">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

        {{-- Image side --}}
        <div class="about-img-frame max-w-sm mx-auto lg:mx-0 reveal">
            <div class="about-img-shadow"></div>
            <div class="about-img-main">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/e/e5/NeemKaroliBaba.jpg/400px-NeemKaroliBaba.jpg"
                     alt="Neem Karoli Baba"
                     onerror="this.src='https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=400&q=80'">
            </div>
            <div class="about-badge">
                <div class="about-badge-num">50+</div>
                <div class="about-badge-lbl">Years of<br>Legacy</div>
            </div>
        </div>

        {{-- Text side --}}
        <div class="reveal reveal-delay-2">
            <span class="sec-eyebrow">Welcome To Our Foundation</span>
            <h2 class="sec-h2 mt-2 mb-5">
                Serving Communities,<br><span class="hl">Transforming Lives</span>
            </h2>

            <div class="about-quote-strip">
                <i class="fas fa-quote-left text-orange-300 text-xl mr-2 float-left mt-1"></i>
                <p class="text-gray-700 italic text-sm leading-relaxed">
                    "Love everyone, serve everyone, remember God, tell the truth."<br>
                    <span class="not-italic font-bold text-orange-600 text-xs">— Neem Karoli Baba (Maharaj-ji)</span>
                </p>
            </div>

            <p class="text-gray-600 leading-relaxed mb-6 text-sm">
                {{ $settings['about_text'] ?? 'The '.$siteName.' is a registered non-profit inspired by the life and teachings of the revered saint Neem Karoli Baba. Rooted in the values of selfless service and unconditional love, we work across North India to uplift communities through healthcare, education, and humanitarian aid.' }}
            </p>

            <div class="grid grid-cols-2 gap-3 mb-7">
                @foreach(['Healthcare Welfare','Education Support','Food Distribution','Women Empowerment'] as $item)
                <div class="about-check">
                    <span class="ck-dot"><i class="fas fa-check"></i></span>
                    {{ $item }}
                </div>
                @endforeach
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('about') }}"
                   class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-7 rounded-xl transition shadow-lg text-sm">
                    Learn More <i class="fas fa-arrow-right text-xs"></i>
                </a>
                <a href="{{ route('activities') }}"
                   class="inline-flex items-center gap-2 border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-bold py-3 px-7 rounded-xl transition text-sm">
                    Our Activities
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ════════ MAHARAJ-JI QUOTE BAND ══════════════════════════════════ --}}
<div class="quote-band py-14 px-4">
    <div class="max-w-3xl mx-auto relative" style="z-index:2;">
        <p class="quote-text-big">
            "The best form of worship is service to mankind."
        </p>
        <p class="quote-attr">— Neem Karoli Baba (Maharaj-ji)</p>
    </div>
</div>

{{-- ════════ IMPACT STATS ═══════════════════════════════════════════ --}}
@if($impactStats->count())
<section class="py-20 px-4 relative overflow-hidden"
         style="background:linear-gradient(135deg,#0C0920 0%,#1a0f3c 50%,#0C0920 100%);">
    <div class="absolute top-0 left-0 w-80 h-80 rounded-full bg-orange-600/8 -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 rounded-full bg-purple-600/15 translate-x-1/3 translate-y-1/3"></div>

    <div class="max-w-7xl mx-auto relative">
        <div class="text-center mb-14 reveal">
            <span class="sec-eyebrow" style="color:#F97316;">Our Impact</span>
            <h2 class="sec-h2 sec-h2w mt-2">Numbers That <span class="hl">Tell Our Story</span></h2>
            <p class="sec-sub sec-subw mt-3 max-w-md mx-auto">
                Every number represents a life touched, a family served, a community uplifted.
            </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($impactStats as $stat)
            <div class="impact-stat-card reveal">
                <div class="impact-icon">
                    <i class="{{ $stat->icon_class ?: 'fas fa-star' }}"></i>
                </div>
                <div class="impact-num counter-num" data-target="{{ preg_replace('/\D/','',$stat->number_value) }}">
                    {{ $stat->number_value }}
                </div>
                <div class="impact-lbl">{{ $stat->label }}</div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-12 reveal">
            <p class="text-purple-300 text-sm italic mb-4">"If you want to see the change, be the change."</p>
            <a href="{{ route('donate') }}"
               class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-3.5 px-8 rounded-xl transition shadow-xl text-sm">
                <i class="fas fa-heart-pulse"></i> Support Our Cause
            </a>
        </div>
    </div>
</section>
@endif

{{-- ════════ RECENT ACTIVITIES ══════════════════════════════════════ --}}
@if($recentActivities->count())
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div class="reveal">
                <span class="sec-eyebrow">What We Do</span>
                <h2 class="sec-h2 mt-2">Recent <span class="hl">Activities</span></h2>
                <p class="sec-sub mt-2 max-w-lg">Fostering positive and everlasting change — uplifting lives, one act of service at a time.</p>
            </div>
            <a href="{{ route('activities') }}"
               class="inline-flex items-center gap-2 border-2 border-orange-600 text-orange-600 hover:bg-orange-600 hover:text-white font-bold py-2.5 px-6 rounded-xl transition text-sm flex-shrink-0 reveal">
                View All <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>

        {{-- Magazine grid --}}
        <div class="act-grid">
            @foreach($recentActivities->take(3) as $i => $activity)
            @php
                $img = $activity->image_url ? (str_starts_with($activity->image_url,'http') ? $activity->image_url : asset('storage/'.$activity->image_url)) : null;
                if(!$img && $activity->youtube_url) {
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $activity->youtube_url, $ym);
                    $ytId = $ym[1] ?? null;
                    $img = $ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : null;
                }
            @endphp
            <div class="act-card {{ $i === 0 ? 'act-featured' : 'act-small' }} reveal reveal-delay-{{ $i+1 }}">
                <div class="act-img">
                    @if($img)
                    <img src="{{ $img }}" alt="{{ $activity->heading }}">
                    @else
                    <div style="height:{{ $i===0?'320px':'170px' }};background:linear-gradient(135deg,#f3e8ff,#fff7ed);display:flex;align-items:center;justify-content:center;">
                        <i class="fas fa-hands-helping text-purple-200 text-4xl"></i>
                    </div>
                    @endif
                </div>
                <div class="act-body">
                    <span class="act-tag"><i class="fas fa-circle" style="font-size:.4rem;"></i> Activity</span>
                    <h3 class="act-title">{{ $activity->heading }}</h3>
                    <div class="act-text rich-text">{!! $activity->description !!}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════ PARTNER ORGANISATIONS ════════════════════════════════ --}}
@if($partners->count())
<section class="py-16 px-4 border-y border-gray-100" style="background:#FFFBF5;">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10 reveal">
            <span class="sec-eyebrow">Collaborations</span>
            <h2 class="sec-h2 mt-2">Our <span class="hl">Mentor Organisations</span></h2>
        </div>
        <div class="swiper partners-swiper reveal">
            <div class="swiper-wrapper items-center">
                @foreach($partners as $partner)
                <div class="swiper-slide px-3">
                    @if($partner->website_url)
                    <a href="{{ $partner->website_url }}" target="_blank" rel="noopener noreferrer"
                       class="partner-card rounded-2xl block" title="{{ $partner->name }}">
                    @else
                    <div class="partner-card rounded-2xl">
                    @endif
                        <img src="{{ $partner->logo_url && !str_starts_with($partner->logo_url,'http') ? asset('storage/'.$partner->logo_url) : $partner->logo_url }}"
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

{{-- ════════ EVENTS ════════════════════════════════════════════════ --}}
@if($events->count())
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div class="reveal">
                <span class="sec-eyebrow">Upcoming &amp; Recent</span>
                <h2 class="sec-h2 mt-2">Events We <span class="hl">Organise</span></h2>
                <p class="sec-sub mt-2">Celebrations, programmes, and drives that bring communities together.</p>
            </div>
            <a href="{{ route('events') }}"
               class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 px-6 rounded-xl transition text-sm flex-shrink-0 reveal">
                All Events <i class="fas fa-arrow-right text-xs"></i>
            </a>
        </div>
        <div class="ev-grid">
            @foreach($events as $i => $event)
            @php
                $eventImg = $event->image_url ? (str_starts_with($event->image_url,'http') ? $event->image_url : asset('storage/'.$event->image_url)) : 'https://picsum.photos/400/250?random='.$event->id;
            @endphp
            <div class="ev-card reveal reveal-delay-{{ $i%4+1 }}">
                <div class="ev-img">
                    <img src="{{ $eventImg }}" alt="{{ $event->heading }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <span class="ev-badge">Event</span>
                </div>
                <div class="ev-body">
                    <p class="ev-cat">{{ $siteName }}</p>
                    <h3 class="ev-title">{{ $event->heading }}</h3>
                    <div class="ev-desc rich-text">{!! $event->description !!}</div>
                    <a href="{{ route('events') }}"
                       class="inline-flex items-center gap-1 text-orange-600 font-semibold text-xs mt-3 hover:gap-2 transition-all">
                        Read More <i class="fas fa-arrow-right text-[9px]"></i>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ════════ LEADERSHIP MESSAGES ════════════════════════════════════ --}}
@if($presidentMessages->count())
<section class="py-16 md:py-20 px-4" style="background:linear-gradient(135deg,#0C0920 0%,#1a0f3c 100%);">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-12 reveal">
            <span class="sec-eyebrow" style="color:#F97316;">Leadership</span>
            <h2 class="sec-h2 sec-h2w mt-2">A Message From Our <span class="hl">Leaders</span></h2>
            <p class="sec-sub sec-subw mt-3 max-w-lg mx-auto">Dedicated personalities striving to foster unity, compassion, and lasting change.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 {{ $presidentMessages->count() >= 3 ? 'lg:grid-cols-3' : '' }} gap-7 items-stretch">
            @foreach($presidentMessages as $i => $pm)
            <div class="reveal reveal-delay-{{ $i % 3 + 1 }} flex flex-col ldr-card-3d"
                 style="background:linear-gradient(160deg,#150D35,#1e1050);
                        border:1px solid rgba(249,115,22,.18);
                        border-radius:20px;overflow:hidden;
                        box-shadow:0 16px 48px rgba(0,0,0,.35);
                        transition:transform .3s,box-shadow .3s;"
                 onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 24px 60px rgba(0,0,0,.45)'"
                 onmouseout="this.style.transform='';this.style.boxShadow='0 16px 48px rgba(0,0,0,.35)'">

                {{-- Card body: 1/3 photo | 2/3 message --}}
                <div class="ldr-card-body" style="display:flex;flex:1;">

                    {{-- LEFT — 1/3 photo panel --}}
                    <div style="width:33.333%;flex-shrink:0;position:relative;overflow:hidden;
                                background:linear-gradient(180deg,#F97316,#ea580c);
                                display:flex;flex-direction:column;align-items:center;
                                justify-content:flex-end;padding:1.25rem .75rem 1rem;
                                text-align:center;min-height:240px;align-self:stretch;">
                        {{-- Photo --}}
                        @if($pm->photo_url)
                        <img src="{{ str_starts_with($pm->photo_url,'http') ? $pm->photo_url : asset('storage/'.$pm->photo_url) }}"
                             alt="{{ $pm->president_name }}"
                             style="width:100%;height:100%;object-fit:contain;object-position:center top;
                                    position:absolute;inset:0;display:block;opacity:.92;padding:.5rem .25rem 0;">
                        @else
                        <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;">
                            <i class="fas fa-user" style="color:rgba(255,255,255,.4);font-size:3rem;"></i>
                        </div>
                        @endif
                        {{-- Gradient overlay --}}
                        <div style="position:absolute;inset:0;
                                    background:linear-gradient(0deg,rgba(12,9,32,.5) 0%,transparent 60%);"></div>
                    </div>

                    {{-- RIGHT — 2/3 message panel --}}
                    <div style="flex:1;display:flex;flex-direction:column;min-width:0;">

                        {{-- Message body --}}
                        <div style="flex:1;padding:1.1rem 1rem .75rem;position:relative;">
                            <div style="position:absolute;top:.3rem;left:.6rem;
                                        font-size:4.5rem;color:rgba(249,115,22,.07);
                                        font-family:Georgia,serif;line-height:1;pointer-events:none;">&ldquo;</div>
                            <div style="color:rgba(255,255,255,.82);font-size:.92rem;font-style:italic;position:relative;z-index:1;"
                                 class="rich-text-dark">
                                {!! $pm->message !!}
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div style="padding:.75rem 1rem .8rem;border-top:1px solid rgba(249,115,22,.18);
                                    display:flex;flex-direction:column;gap:.5rem;">
                            {{-- Signature row (always shown) --}}
                            <div style="min-height:40px;display:flex;align-items:center;">
                                @if($pm->signature_url)
                                <img src="{{ str_starts_with($pm->signature_url,'http') ? $pm->signature_url : asset('storage/'.$pm->signature_url) }}"
                                     alt="Signature"
                                     style="max-height:52px;max-width:160px;width:auto;object-fit:contain;
                                            border-radius:6px;background:rgba(255,255,255,.06);padding:4px 6px;">
                                @else
                                {{-- Placeholder keeps the row height consistent --}}
                                <span style="display:block;height:40px;"></span>
                                @endif
                            </div>
                            {{-- Name + Jai Ram Ji Ki --}}
                            <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem;">
                                <div>
                                    <p style="color:#fff;font-size:.78rem;font-weight:700;line-height:1.2;">{{ $pm->president_name }}</p>
                                    @if($pm->president_title)
                                    <p style="color:rgba(249,115,22,.8);font-size:.65rem;font-weight:500;margin-top:.15rem;">{{ $pm->president_title }}</p>
                                    @endif
                                </div>
                                <div style="display:flex;align-items:center;gap:.35rem;flex-shrink:0;">
                                    <div style="height:1px;width:18px;background:rgba(249,115,22,.4);"></div>
                                    <span style="color:#F97316;font-size:.6rem;font-weight:700;font-style:italic;white-space:nowrap;">
                                        Jai Ram Ji Ki
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            @endforeach
        </div>

    </div>
</section>
@endif

{{-- ════════ WORK IN ACTION — VIDEOS ═══════════════════════════════ --}}
<section class="py-20 px-4 video-section-bg">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-14 reveal">
            <div class="inline-flex items-center gap-2 mb-3">
                <div class="h-px w-10 bg-orange-500"></div>
                <span class="text-orange-400 text-xs font-bold uppercase tracking-widest">Watch &amp; Learn</span>
                <div class="h-px w-10 bg-orange-500"></div>
            </div>
            <h2 class="sec-h2 sec-h2w mt-1">See Our <span class="hl">Work in Action</span></h2>
            <p class="sec-sub sec-subw mt-3 max-w-xl mx-auto">
                Real moments, real lives changed — watch our programmes and drives on the ground.
            </p>
        </div>

        @if($workVideos->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($workVideos as $i => $vid)
            @php $ytId = $vid->youtube_id; @endphp
            <div class="work-video-card group relative bg-gray-900 rounded-2xl overflow-hidden shadow-lg border border-white/8
                        hover:border-orange-500/45 hover:-translate-y-2 hover:shadow-orange-900/35 hover:shadow-2xl
                        transition-all duration-400 cursor-pointer reveal reveal-delay-{{ $i%4+1 }}"
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
                    <h3 class="text-white font-bold text-sm leading-snug mb-1.5 group-hover:text-orange-300 transition-colors">{{ $vid->title }}</h3>
                    @if($vid->description)
                    <div class="text-gray-400 text-xs rich-text-dark">{!! $vid->description !!}</div>
                    @endif
                    <div class="mt-3 flex items-center gap-1.5 text-orange-400 text-xs font-semibold">
                        <i class="fas fa-play-circle text-sm"></i> Watch Now
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 reveal">
            <div class="w-20 h-20 rounded-full bg-white/8 border border-white/15 flex items-center justify-center mx-auto mb-5">
                <i class="fab fa-youtube text-red-400 text-3xl"></i>
            </div>
            <p class="text-purple-300 text-base font-semibold mb-2">Videos coming soon!</p>
            <p class="text-purple-400 text-sm">Our team is uploading programme videos. Check back shortly.</p>
        </div>
        @endif

        <div class="text-center mt-10 reveal">
            <a href="{{ route('work-in-action') }}"
               class="inline-flex items-center gap-2 bg-white/8 hover:bg-white/15 border border-white/15 text-white font-bold py-3 px-8 rounded-xl transition text-sm">
                <i class="fab fa-youtube"></i> View All Videos
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

{{-- ════════ MEDIA COVERAGE PREVIEW ════════════════════════════════ --}}
<section class="py-20 px-4 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-12">
            <div class="text-center md:text-left reveal">
                <span class="sec-eyebrow">Press &amp; Media</span>
                <h2 class="sec-h2 mt-2">Featured In <span class="hl">Media</span></h2>
                <p class="sec-sub mt-2">News channels, TV, and online media coverage of our work</p>
            </div>
            <a href="{{ route('media-coverage') }}"
               class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-700 text-white font-bold py-2.5 px-6 rounded-xl transition text-sm flex-shrink-0 reveal">
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
            <div class="media-card group flex flex-col reveal reveal-delay-{{ $i%3+1 }}">
                <div class="relative overflow-hidden h-48 bg-gray-100">
                    <img src="{{ $img }}" alt="{{ $cov->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                    <span class="absolute top-3 left-3 {{ $catColor }} text-white text-[10px] font-bold px-2 py-1 rounded-full">{{ $catLabel }}</span>
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
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2">{{ $cov->title }}</h3>
                    @if($cov->description)
                    <div class="text-gray-500 text-xs mb-4 flex-1 rich-text">{!! $cov->description !!}</div>
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
                           class="inline-flex items-center gap-1.5 bg-orange-50 hover:bg-orange-100 text-orange-700 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                            <i class="fas fa-external-link-alt text-xs"></i> Read Article
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
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

{{-- ════════ DONATE ANIMATION BAND ══════════════════════════════════ --}}
<section id="donate-anim-band" style="
    position:relative;overflow:hidden;
    background:linear-gradient(135deg,#0C0920 0%,#1a0432 45%,#0C0920 100%);
    padding:5rem 1rem;">

    {{-- Animated ripple rings --}}
    <div style="position:absolute;inset:0;display:flex;align-items:center;justify-content:center;pointer-events:none;">
        <span class="donate-ring donate-ring-1"></span>
        <span class="donate-ring donate-ring-2"></span>
        <span class="donate-ring donate-ring-3"></span>
        <span class="donate-ring donate-ring-4"></span>
    </div>

    {{-- Floating dots background --}}
    <div style="position:absolute;inset:0;overflow:hidden;pointer-events:none;">
        @for($d=1;$d<=18;$d++)
        <span class="donate-dot donate-dot-{{ $d }}"></span>
        @endfor
    </div>

    <div style="position:relative;z-index:2;max-width:860px;margin:0 auto;text-align:center;">

        {{-- Central icon with pulse --}}
        <div style="display:inline-flex;align-items:center;justify-content:center;
                    width:90px;height:90px;border-radius:50%;
                    background:linear-gradient(135deg,#F97316,#ea580c);
                    box-shadow:0 0 0 0 rgba(249,115,22,.6);
                    animation:heartPulse 1.8s ease-in-out infinite;
                    margin-bottom:1.75rem;">
            <i class="fas fa-hands-holding-heart" style="font-size:2.2rem;color:#fff;"></i>
        </div>

        {{-- Animated heading --}}
        <h2 class="donate-anim-title">
            Every Rupee<br>
            <span style="background:linear-gradient(90deg,#F97316,#FCD34D,#F97316);
                         background-size:200% auto;
                         -webkit-background-clip:text;-webkit-text-fill-color:transparent;
                         background-clip:text;
                         animation:shimmerText 3s linear infinite;">
                Transforms a Life
            </span>
        </h2>

        <p style="color:rgba(255,255,255,.65);font-size:1rem;line-height:1.75;max-width:520px;margin:1rem auto 0;">
            Feed the hungry. Educate a child. Support a patient.<br>
            <strong style="color:rgba(255,255,255,.9);">Tax-exempt under 80G — every donation counts.</strong>
        </p>

        {{-- Animated stats row — pulled from DB via $impactStats --}}
        @if($impactStats->count())
        <div style="display:flex;justify-content:center;gap:3rem;flex-wrap:wrap;margin:2.5rem 0;">
            @foreach($impactStats as $stat)
            <div class="donate-stat-box">
                @php
                    // Strip non-numeric chars (e.g. "50L+", "5,000+") to get raw number for counter
                    $rawNum = (int) preg_replace('/[^0-9]/', '', $stat->number_value);
                    $suffix = preg_replace('/[0-9,\s]/', '', $stat->number_value); // e.g. "L+", "+"
                @endphp
                <span class="donate-counter" data-target="{{ $rawNum }}">0</span><span style="color:#F97316;font-size:1.4rem;font-weight:900;">{{ $suffix ?: '+' }}</span>
                <p>{{ $stat->label }}</p>
            </div>
            @endforeach
        </div>
        @endif

        {{-- CTA buttons --}}
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <a href="{{ route('donate') }}" class="donate-anim-btn">
                <i class="fas fa-heart-pulse"></i>
                <span>Donate Now</span>
                <span class="donate-btn-shine"></span>
            </a>
            <a href="{{ route('join-us') }}" style="
                display:inline-flex;align-items:center;gap:.5rem;
                border:2px solid rgba(249,115,22,.45);color:#CBD5E1;
                font-weight:700;font-size:.95rem;
                padding:.85rem 2rem;border-radius:50px;
                text-decoration:none;transition:all .3s;
                background:rgba(249,115,22,.05);">
                <i class="fas fa-user-plus"></i> Join Us
            </a>
        </div>

        {{-- Trust badges --}}
        <div style="display:flex;justify-content:center;gap:1rem;flex-wrap:wrap;margin-top:2rem;">
            <span style="display:inline-flex;align-items:center;gap:.4rem;
                         background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);
                         color:rgba(255,255,255,.6);font-size:.72rem;font-weight:600;
                         padding:.35rem .9rem;border-radius:50px;">
                <i class="fas fa-shield-halved" style="color:#F97316;"></i> 12A &amp; 80G Certified
            </span>
            <span style="display:inline-flex;align-items:center;gap:.4rem;
                         background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);
                         color:rgba(255,255,255,.6);font-size:.72rem;font-weight:600;
                         padding:.35rem .9rem;border-radius:50px;">
                <i class="fas fa-check-circle" style="color:#4ade80;"></i> Govt. Registered NGO
            </span>
            <span style="display:inline-flex;align-items:center;gap:.4rem;
                         background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);
                         color:rgba(255,255,255,.6);font-size:.72rem;font-weight:600;
                         padding:.35rem .9rem;border-radius:50px;">
                <i class="fas fa-lock" style="color:#60a5fa;"></i> 100% Secure &amp; Transparent
            </span>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
// Hero slider
new Swiper('.hero-swiper', {
    loop: true,
    effect: 'creative',
    creativeEffect: {
        prev: { shadow: true, translate: ['-105%', 0, -500], opacity: 0 },
        next: { translate: ['105%', 0, 0], opacity: 0.5 },
    },
    autoplay: { delay: 5500, disableOnInteraction: false },
    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
    pagination: {
        el: '.swiper-pagination', clickable: true,
        renderBullet: function(index, cls) {
            return `<span class="${cls}" style="width:8px;height:8px;background:rgba(255,255,255,0.5);border-radius:4px;transition:all 0.3s;"></span>`;
        },
    },
    speed: 800,
    on: {
        slideChangeTransitionStart: function() {
            const active = this.slides[this.activeIndex];
            if (!active) return;
            active.querySelectorAll('.hero-text-in,.hero-nkb-portrait,.hero-quote-chip,.hero-border-line').forEach(el => {
                el.style.animation = 'none'; el.offsetHeight; el.style.animation = '';
            });
        }
    }
});

// Partners carousel
@if(isset($partners) && $partners->count())
new Swiper('.partners-swiper', {
    loop: true,
    autoplay: { delay: 2500, disableOnInteraction: false },
    slidesPerView: 2, spaceBetween: 16,
    breakpoints: {
        480: { slidesPerView: 3, spaceBetween: 20 },
        768: { slidesPerView: 4, spaceBetween: 24 },
        1024: { slidesPerView: 5, spaceBetween: 24 },
    },
});
@endif

// Work video modal
function openWorkVideo(ytId, title) {
    if (!ytId) return;
    document.getElementById('workVideoFrame').src = 'https://www.youtube.com/embed/'+ytId+'?autoplay=1&rel=0&modestbranding=1';
    document.getElementById('workVideoTitle').textContent = title || '';
    const m = document.getElementById('workVideoModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeWorkVideo() {
    document.getElementById('workVideoFrame').src = '';
    const m = document.getElementById('workVideoModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    document.body.style.overflow = '';
}
document.getElementById('workVideoModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeWorkVideo();
});

// Home media video modal
function openHomeMediaVideo(ytId, title) {
    if (!ytId) return;
    document.getElementById('homeMediaFrame').src = 'https://www.youtube.com/embed/'+ytId+'?autoplay=1&rel=0&modestbranding=1';
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
document.getElementById('homeMediaModal')?.addEventListener('click', function(e) {
    if (e.target === this) closeHomeMediaVideo();
});

// Counter animation
const counterEls = document.querySelectorAll('.counter-num[data-target]');
const counterObs = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const target = parseInt(el.dataset.target) || 0;
        if (!target) return;
        let start = 0; const duration = 1800;
        const step = timestamp => {
            if (!start) start = timestamp;
            const progress = Math.min((timestamp - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target).toLocaleString('en-IN') + (el.dataset.suffix || '+');
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
        counterObs.unobserve(el);
    });
}, { threshold: 0.4 });
counterEls.forEach(el => counterObs.observe(el));

// Scroll reveal
const revealEls = document.querySelectorAll('.reveal');
const revealObs = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) { e.target.classList.add('revealed'); revealObs.unobserve(e.target); }
    });
}, { threshold: 0.1 });
revealEls.forEach(el => revealObs.observe(el));

// ── Donate counter animation ──────────────────────────────────────
(function(){
    const counters = document.querySelectorAll('.donate-counter');
    if(!counters.length) return;
    const obs = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if(!entry.isIntersecting) return;
            const el = entry.target;
            const target = +el.dataset.target;
            const duration = 2000;
            const step = Math.ceil(target / (duration / 16));
            let current = 0;
            const timer = setInterval(() => {
                current = Math.min(current + step, target);
                el.textContent = current.toLocaleString('en-IN');
                if(current >= target) clearInterval(timer);
            }, 16);
            obs.unobserve(el);
        });
    }, { threshold: 0.4 });
    counters.forEach(c => obs.observe(c));
})();
</script>
@endpush
