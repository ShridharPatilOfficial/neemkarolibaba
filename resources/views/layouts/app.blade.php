<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="xGChHEAZUfdePsZtCZ25SZmYZZb1ySZkLlJ-l93ecpg" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $metaTitle = trim(strip_tags(\Illuminate\Support\Str::limit(
            $__env->yieldContent('title') ?: 'Neem Karoli Baba Charitable Trust', 60
        )));
        $metaDesc  = trim(strip_tags(
            $__env->yieldContent('meta_desc') ?: 'Neem Karoli Baba Charitable Trust – serving humanity through education, healthcare & community welfare inspired by Neem Karoli Baba (Maharaj-ji). 12A & 80G registered NGO in India.'
        ));
        $metaImg   = $__env->yieldContent('og_image') ?: asset('images/og-default.jpg');
        $canonical = $__env->yieldContent('canonical') ?: url()->current();
        $siteName  = \App\Models\SiteSetting::get('site_name', 'Neem Karoli Baba Charitable Trust');
    @endphp

    {{-- Primary --}}
    <title>{{ $metaTitle }}</title>
    <meta name="description"  content="{{ $metaDesc }}">
    <meta name="keywords"     content="@yield('meta_keywords', 'Neem Karoli Baba Charitable Trust, NKB Foundation, NGO India, Maharaj-ji, charity, donate India, 80G registered')">
    <meta name="author"       content="{{ $siteName }}">
    <meta name="robots"       content="@yield('robots', 'index, follow')">
    <meta name="theme-color"  content="#4C1D95">
    <link rel="canonical"     href="{{ $canonical }}">

    {{-- Open Graph --}}
    <meta property="og:type"         content="website">
    <meta property="og:site_name"    content="{{ $siteName }}">
    <meta property="og:title"        content="{{ $metaTitle }}">
    <meta property="og:description"  content="{{ $metaDesc }}">
    <meta property="og:url"          content="{{ $canonical }}">
    <meta property="og:image"        content="{{ $metaImg }}">
    <meta property="og:image:width"  content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale"       content="en_IN">

    {{-- Twitter Card --}}
    <meta name="twitter:card"        content="summary_large_image">
    <meta name="twitter:title"       content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDesc }}">
    <meta name="twitter:image"       content="{{ $metaImg }}">

    {{-- Favicon — use Maharaj-ji header photo if uploaded, else fallback --}}
    @php $faviconUrl = $headerPhoto ?? asset('favicon.svg'); @endphp
    <link rel="icon"             href="{{ $faviconUrl }}" type="image/jpeg">
    <link rel="shortcut icon"    href="{{ $faviconUrl }}">
    <link rel="apple-touch-icon" href="{{ $faviconUrl }}">

    {{-- Organisation JSON-LD (global) --}}
    @php
        $orgPhone   = \App\Models\SiteSetting::get('phone', '');
        $orgEmail   = \App\Models\SiteSetting::get('email', '');
        $orgAddress = \App\Models\SiteSetting::get('address', '');
        $orgFb      = \App\Models\SiteSetting::get('facebook', '');
        $orgIg      = \App\Models\SiteSetting::get('instagram', '');
        $orgYt      = \App\Models\SiteSetting::get('youtube', '');
    @endphp
    <script type="application/ld+json">
    {
      "@@context": "https://schema.org",
      "@@type": "NGO",
      "name": "{{ $siteName }}",
      "alternateName": "NKB Foundation",
      "url": "{{ config('app.url') }}",
      "logo": "{{ $headerPhoto ?? asset('favicon.svg') }}",
      "description": "A registered non-profit organisation inspired by the teachings of Neem Karoli Baba (Maharaj-ji), dedicated to education, healthcare and community service.",
      "foundingDate": "2020",
      "areaServed": "IN",
      "taxID": "{{ \App\Models\SiteSetting::get('reg_no', '') }}",
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "{{ $orgPhone }}",
        "email": "{{ $orgEmail }}",
        "contactType": "customer support",
        "availableLanguage": ["English", "Hindi"]
      },
      "address": {
        "@@type": "PostalAddress",
        "addressLocality": "Chandigarh",
        "addressCountry": "IN",
        "streetAddress": "{{ $orgAddress }}"
      },
      "sameAs": ["{{ $orgFb }}", "{{ $orgIg }}", "{{ $orgYt }}"]
    }
    </script>

    @stack('schema')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    @php
        $cssApp  = asset('css/app.css')  . '?v=' . @filemtime(public_path('css/app.css'));
        $cssSite = asset('css/site.css') . '?v=' . @filemtime(public_path('css/site.css'));
        $jsApp   = asset('js/app.js')    . '?v=' . @filemtime(public_path('js/app.js'));
    @endphp
    <link rel="stylesheet" href="{{ $cssApp }}">
    <link rel="stylesheet" href="{{ $cssSite }}">
    <script src="{{ $jsApp }}" defer></script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-800 overflow-x-hidden">

{{-- ═══ UNIFIED SITE HEADER ═══════════════════════════════════════ --}}
<div id="site-header">
    <div class="max-w-7xl mx-auto px-4">
        <div class="sh-inner">

            {{-- Photo card --}}
            @if($headerPhoto)
            <div id="header-photo-wrap" class="sh-photo">
                <img id="header-photo" src="{{ $headerPhoto }}" alt="{{ $siteName }}">
            </div>
            @else
            <div class="sh-logo-wrap">
                <span style="font-size:2.5rem;color:#F97316;font-family:serif;">ॐ</span>
            </div>
            @endif

            {{-- Trust info --}}
            <div class="sh-info">
                <h1 class="sh-name">{{ $siteName }}</h1>
                <p class="sh-tag">
                    <i class="fas fa-shield-halved" style="font-size:.55rem;"></i>
                    {{ $siteTagline }}
                </p>
                <div class="sh-contacts hidden md:flex">
                    <a href="mailto:{{ \App\Models\SiteSetting::get('email','') }}">
                        <i class="fas fa-envelope"></i>
                        {{ \App\Models\SiteSetting::get('email','support@neemkarolibaba.org.in') }}
                    </a>
                    <a href="tel:{{ \App\Models\SiteSetting::get('phone','') }}">
                        <i class="fas fa-phone"></i>
                        {{ \App\Models\SiteSetting::get('phone','+91 94644 33808') }}
                    </a>
                    <span>Reg No: {{ \App\Models\SiteSetting::get('reg_no','') }}</span>
                    <span style="display:flex;align-items:center;gap:.3rem;color:#F97316;font-weight:700;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#22c55e;display:inline-block;animation:pulse 2s infinite;flex-shrink:0;"></span>
                        <i class="fas fa-users" style="font-size:.58rem;color:#F97316;"></i>
                        {{ number_format($frontendVisitors) }} Visitors
                    </span>
                </div>
            </div>

            {{-- Actions --}}
            <div class="sh-actions">
                <div class="sh-socials">
                    @foreach(['facebook','instagram','youtube'] as $sn)
                    @php $surl = \App\Models\SiteSetting::get($sn, '#'); @endphp
                    <a href="{{ $surl }}" target="_blank" rel="noopener" class="sh-si">
                        <i class="fab fa-{{ $sn }}"></i>
                    </a>
                    @endforeach
                </div>
                <div class="sh-donate-wrap">
                    <a href="{{ route('donate') }}#payment-section" class="donate-btn">
                        <i class="fas fa-heart btn-heart"></i> DONATE US
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ═══ NAVIGATION ════════════════════════════════════════════════ --}}
<nav id="main-nav">
    <div class="max-w-7xl mx-auto px-4">
        <div class="nav-inner">

            {{-- Desktop links --}}
            <ul class="nav-links-desktop hidden lg:flex">
                <li>
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                </li>
                <li class="nav-dd">
                    <button class="nav-link {{ request()->routeIs('about*') && !request()->routeIs('about.objectives') ? 'active' : '' }}">
                        About Us <i class="fas fa-chevron-down" style="font-size:.6rem;margin-left:.2rem;"></i>
                    </button>
                    <div class="nav-dd-menu">
                        <a href="{{ route('about') }}" class="nav-dd-item">About Us</a>
                        <a href="{{ route('about.founders') }}" class="nav-dd-item">Founder Member</a>
                        <a href="{{ route('about.org-profile') }}" class="nav-dd-item">Organisation Profile</a>
                        <a href="{{ route('about.documents') }}" class="nav-dd-item">Document Gallery</a>
                    </div>
                </li>
                <li>
                    <a href="{{ route('about.objectives') }}" class="nav-link {{ request()->routeIs('about.objectives') ? 'active' : '' }}">Objectives of Trust</a>
                </li>
                <li class="nav-dd">
                    <button class="nav-link {{ request()->routeIs('gallery','media-coverage','work-in-action') ? 'active' : '' }}">
                        Media <i class="fas fa-chevron-down" style="font-size:.6rem;margin-left:.2rem;"></i>
                    </button>
                    <div class="nav-dd-menu">
                        <a href="{{ route('gallery') }}" class="nav-dd-item">Photo &amp; Video Gallery</a>
                        <a href="{{ route('work-in-action') }}" class="nav-dd-item">Work in Action</a>
                        <a href="{{ route('media-coverage') }}" class="nav-dd-item">Media Coverage</a>
                    </div>
                </li>
                @foreach([
                    ['Our Activities','activities','activities'],
                    ['Events','events','events'],
                    ['Future Plan','future-plan','future-plan'],
                    ['Join Us','join-us','join-us'],
                    ['Contact Us','contact','contact'],
                ] as [$lbl,$rt,$mt])
                <li>
                    <a href="{{ route($rt) }}" class="nav-link {{ request()->routeIs($mt) ? 'active' : '' }}">{{ $lbl }}</a>
                </li>
                @endforeach
                <li>
                    <a href="{{ route('appeal') }}" class="nav-link {{ request()->routeIs('appeal') ? 'active' : '' }}">Appeal</a>
                </li>
                <li>
                    <a href="{{ route('donate') }}#payment-section" class="nav-donate-pill">Donate Us</a>
                </li>
            </ul>

            {{-- Mobile toggle --}}
            <button id="nav-toggle" class="nav-mobile-btn lg:hidden" aria-label="Menu">
                <i class="fas fa-bars"></i>
            </button>

        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="nav-mobile-menu hidden lg:hidden">
            <a href="{{ route('home') }}" class="nav-mob-item">
                <i class="fas fa-home text-orange-400 w-4"></i> Home
            </a>
            <p class="nav-mob-section">About Us</p>
            <a href="{{ route('about') }}" class="nav-mob-item">
                <i class="fas fa-info-circle text-orange-400 w-4"></i> About Us
            </a>
            <a href="{{ route('about.founders') }}" class="nav-mob-item">
                <i class="fas fa-users text-orange-400 w-4"></i> Founder Member
            </a>
            <a href="{{ route('about.org-profile') }}" class="nav-mob-item">
                <i class="fas fa-building text-orange-400 w-4"></i> Organisation Profile
            </a>
            <a href="{{ route('about.documents') }}" class="nav-mob-item">
                <i class="fas fa-file text-orange-400 w-4"></i> Document Gallery
            </a>
            <a href="{{ route('about.objectives') }}" class="nav-mob-item">
                <i class="fas fa-list-ul text-orange-400 w-4"></i> Objectives of Trust
            </a>
            <p class="nav-mob-section">Media</p>
            <a href="{{ route('gallery') }}" class="nav-mob-item">
                <i class="fas fa-images text-orange-400 w-4"></i> Gallery
            </a>
            <a href="{{ route('work-in-action') }}" class="nav-mob-item">
                <i class="fab fa-youtube text-orange-400 w-4"></i> Work in Action
            </a>
            <a href="{{ route('media-coverage') }}" class="nav-mob-item">
                <i class="fas fa-newspaper text-orange-400 w-4"></i> Media Coverage
            </a>
            <p class="nav-mob-section">Pages</p>
            @foreach([
                ['Our Activities','activities','fa-hands-helping'],
                ['Events','events','fa-calendar-days'],
                ['Future Plan','future-plan','fa-rocket'],
                ['Join Us','join-us','fa-user-plus'],
                ['Contact Us','contact','fa-envelope'],
                ['Appeal','appeal','fa-envelope-open-text'],
                ['Donate Us','donate','fa-heart'],
            ] as [$lbl,$rt,$ic])
            @php $mhref = $rt==='donate' ? route('donate').'#payment-section' : route($rt); @endphp
            <a href="{{ $mhref }}" class="nav-mob-item">
                <i class="fas {{ $ic }} text-orange-400 w-4"></i> {{ $lbl }}
            </a>
            @endforeach
        </div>
    </div>
</nav>


{{-- ─── Ticker ──────────────────────────────────────────────────── --}}
@php
    $tickerText = \App\Models\SiteSetting::get('ticker')
        ?: \App\Models\SiteSetting::get('ticker_text', 'Welcome to '.$siteName.' | Love All, Serve All | Join us in our mission of compassion and service');
@endphp
<div class="bg-emerald-700 text-white py-1.5 overflow-hidden text-xs">
    <div class="ticker-wrap">
        <div class="ticker-content font-medium">
            <i class="fas fa-bullhorn text-yellow-300 mr-3"></i>
            {{ $tickerText }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fas fa-hand-holding-heart text-yellow-300 mr-3"></i>
            {{ $tickerText }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
    </div>
</div>

{{-- ─── Main Content ────────────────────────────────────────────── --}}
<main>
    @yield('content')
</main>

{{-- ─── Footer ──────────────────────────────────────────────────── --}}
<footer class="bg-gray-950 text-white pt-16 pb-6">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Top brand row --}}
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 mb-10 pb-10 border-b border-gray-800">
            <div class="flex items-center gap-4">
                @if($headerPhoto)
                <img src="{{ $headerPhoto }}" alt="{{ $siteName }}"
                     class="w-16 h-16 rounded-xl shadow-lg flex-shrink-0 object-cover object-top">
                @endif
                <div>
                    <p class="font-bold text-lg leading-tight">{{ $siteName }}</p>
                    <p class="text-gray-400 text-sm italic">"Love All, Serve All"</p>
                </div>
            </div>
            <a href="{{ route('donate') }}#payment-section"
               class="donate-btn py-3 px-7 rounded-xl flex items-center gap-2 text-sm shadow-lg flex-shrink-0">
                <i class="fas fa-heart btn-heart"></i> Support Our Mission
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">

            {{-- About --}}
            <div>
                <h3 class="font-bold text-sm uppercase tracking-wider text-orange-400 mb-4">About Foundation</h3>
                <p class="text-gray-400 text-sm leading-relaxed mb-4">
                    A not-for-profit philanthropic organisation inspired by the teachings of Neem Karoli Baba — dedicated to education, healthcare &amp; community service.
                </p>
                <div class="flex gap-2">
                    @foreach([
                        ['facebook', 'bg-blue-600'],
                        ['instagram', 'bg-gradient-to-tr from-pink-500 to-orange-400'],
                        ['youtube', 'bg-red-600'],
                        ['whatsapp', 'bg-green-600'],
                    ] as [$sn, $bg])
                    @php $url = \App\Models\SiteSetting::get($sn, '#'); @endphp
                    <a href="{{ $sn === 'whatsapp' ? 'https://wa.me/' . $url : $url }}" target="_blank" rel="noopener"
                       class="w-8 h-8 rounded-lg {{ $bg }} flex items-center justify-center text-xs hover:opacity-80 transition">
                        <i class="fab fa-{{ $sn }}"></i>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h3 class="font-bold text-sm uppercase tracking-wider text-orange-400 mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    @foreach([
                        ['Home', 'home'],
                        ['About Us', 'about.founders'],
                        ['Our Activities', 'activities'],
                        ['Events', 'events'],
                        ['Join Us', 'join-us'],
                        ['Gallery', 'gallery'],
                        ['Donate Us', 'donate'],
                        ['Contact Us', 'contact'],
                    ] as [$label, $route])
                    <li>
                        @php $fLink = $route === 'donate' ? route('donate').'#payment-section' : route($route); @endphp
                        <a href="{{ $fLink }}" class="flex items-center gap-2 hover:text-orange-400 transition group">
                            <i class="fas fa-chevron-right text-[10px] text-orange-500 group-hover:translate-x-1 transition-transform"></i>
                            {{ $label }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- Gallery mini --}}
            <div>
                <h3 class="font-bold text-sm uppercase tracking-wider text-orange-400 mb-4">Gallery</h3>
                <div class="grid grid-cols-3 gap-1.5">
                    @php $galleryFooter = \App\Models\GalleryItem::where('is_active', true)->where('type', '!=', 'video')->orderBy('sort_order')->take(6)->get(); @endphp
                    @forelse($galleryFooter as $g)
                    <a href="{{ route('gallery') }}" class="block rounded-lg overflow-hidden">
                        <img src="{{ $g->image_url && !str_starts_with($g->image_url, 'http') ? asset('storage/' . $g->image_url) : ($g->image_url ?: 'https://picsum.photos/80/80?random=' . $g->id) }}"
                             class="w-full h-16 object-cover hover:opacity-80 transition" alt="">
                    </a>
                    @empty
                        @for($i=1;$i<=6;$i++)
                        <a href="{{ route('gallery') }}" class="block rounded-lg overflow-hidden">
                            <img src="https://picsum.photos/80/80?random={{ $i+100 }}" class="w-full h-16 object-cover hover:opacity-80 transition" alt="">
                        </a>
                        @endfor
                    @endforelse
                </div>
            </div>

            {{-- Contact --}}
            <div>
                <h3 class="font-bold text-sm uppercase tracking-wider text-orange-400 mb-4">Get In Touch</h3>
                <ul class="space-y-4 text-sm text-gray-400">
                    <li class="flex items-start gap-3">
                        <span class="w-8 h-8 rounded-lg bg-orange-600/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <i class="fas fa-map-marker-alt text-orange-400 text-xs"></i>
                        </span>
                        <span class="leading-relaxed">{{ \App\Models\SiteSetting::get('address', 'Sector 22, Chandigarh, India – 160022') }}</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-orange-600/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-phone text-orange-400 text-xs"></i>
                        </span>
                        <a href="tel:{{ \App\Models\SiteSetting::get('phone') }}" class="hover:text-orange-400 transition">
                            {{ \App\Models\SiteSetting::get('phone', '+91 98765 43210') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-lg bg-orange-600/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-envelope text-orange-400 text-xs"></i>
                        </span>
                        <a href="mailto:{{ \App\Models\SiteSetting::get('email') }}" class="hover:text-orange-400 transition break-all">
                            {{ \App\Models\SiteSetting::get('email', 'info@nkbfoundation.org') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row items-center justify-between gap-3 text-xs text-gray-500">
            <p>&copy; {{ date('Y') }} {{ $siteName }}. All Rights Reserved.</p>

            {{-- Visitor counter --}}
            <p class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-orange-500 inline-block animate-pulse"></span>
                <i class="fas fa-users text-orange-500"></i>
                <span class="text-gray-400">
                    <span class="font-bold text-orange-400">{{ number_format($frontendVisitors) }}</span>
                    Unique Visitors
                </span>
            </p>

            <p class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span>
                12A &amp; 80G Registered &nbsp;|&nbsp; Reg. No: {{ \App\Models\SiteSetting::get('reg_no', 'XXXXXX/2024') }}
            </p>
        </div>
    </div>
</footer>

{{-- ─── Floating Donate Button ─────────────────────────────────── --}}
<div id="float-donate">
    {{-- Pulse rings --}}
    <div class="fd-ring fd-r1"></div>
    <div class="fd-ring fd-r2"></div>

    <a href="{{ route('donate') }}#payment-section" class="fd-pill">
        <span class="fd-icon-wrap">
            <i class="fas fa-hands-holding-heart fd-icon-fa"></i>
        </span>
        <span class="fd-label">DONATE US</span>
        <span class="fd-shine"></span>
    </a>
</div>

{{-- ─── WhatsApp Floating Button ────────────────────────────────── --}}
<a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp', '919876543210') }}"
   target="_blank" rel="noopener"
   class="wa-btn fixed bottom-6 right-6 z-50 w-14 h-14 bg-green-500 hover:bg-green-600 rounded-full flex items-center justify-center shadow-xl transition">
    <i class="fab fa-whatsapp text-white text-3xl"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    // Mobile nav
    document.getElementById('nav-toggle')?.addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
        const icon = this.querySelector('i');
        icon.classList.toggle('fa-bars');
        icon.classList.toggle('fa-times');
    });

    // Sticky nav shadow on scroll + show/hide floating donate
    const nav = document.getElementById('main-nav');
    const floatDonate = document.getElementById('float-donate');
    let fdVisible = false;
    window.addEventListener('scroll', () => {
        nav?.classList.toggle('nav-scrolled', window.scrollY > 50);
        const shouldShow = window.scrollY > 200;
        if (shouldShow && !fdVisible) {
            fdVisible = true;
            floatDonate?.classList.remove('hiding');
            floatDonate?.classList.add('visible');
        } else if (!shouldShow && fdVisible) {
            fdVisible = false;
            floatDonate?.classList.remove('visible');
            floatDonate?.classList.add('hiding');
            setTimeout(() => floatDonate?.classList.remove('hiding'), 380);
        }
    });

    // Reveal on scroll
    const reveals = document.querySelectorAll('.reveal');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(e => { if(e.isIntersecting) e.target.classList.add('visible'); });
    }, { threshold: 0.12 });
    reveals.forEach(el => observer.observe(el));
</script>
@stack('scripts')

{{-- ══════════════════════════════════════════════════════════════
     UNIVERSAL IMAGE LIGHTBOX — works on every page
     Usage: <img onclick="imgLb(this)" data-full="URL" data-caption="Title">
     or just: imgLb(src, caption)
════════════════════════════════════════════════════════════════ --}}
<div id="imgLbOverlay"
     style="display:none;position:fixed;inset:0;z-index:99999;
            background:rgba(0,0,0,.94);backdrop-filter:blur(10px);
            cursor:zoom-out;align-items:center;justify-content:center;"
     onclick="closeLb(event)">

    {{-- Close btn --}}
    <button onclick="closeLb()" aria-label="Close"
            style="position:absolute;top:1rem;right:1rem;
                   width:2.5rem;height:2.5rem;border-radius:50%;
                   background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
                   color:#fff;font-size:1.1rem;display:flex;align-items:center;justify-content:center;
                   cursor:pointer;transition:background .2s;z-index:2;"
            onmouseover="this.style.background='rgba(249,115,22,.7)'"
            onmouseout="this.style.background='rgba(255,255,255,.12)'">
        <i class="fas fa-times"></i>
    </button>

    {{-- Expand icon --}}
    <a id="imgLbFull" href="#" target="_blank" rel="noopener"
       style="position:absolute;top:1rem;right:4rem;
              width:2.5rem;height:2.5rem;border-radius:50%;
              background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);
              color:#fff;font-size:.9rem;display:flex;align-items:center;justify-content:center;
              transition:background .2s;z-index:2;"
       title="Open full size"
       onmouseover="this.style.background='rgba(249,115,22,.7)'"
       onmouseout="this.style.background='rgba(255,255,255,.12)'">
        <i class="fas fa-arrow-up-right-from-square"></i>
    </a>

    {{-- Image --}}
    <div style="position:relative;max-width:92vw;max-height:88vh;display:flex;flex-direction:column;align-items:center;gap:.75rem;"
         onclick="event.stopPropagation()">
        <img id="imgLbImg" src="" alt=""
             style="max-width:90vw;max-height:80vh;object-fit:contain;
                    border-radius:12px;box-shadow:0 32px 80px rgba(0,0,0,.8);
                    display:block;">
        <p id="imgLbCaption"
           style="color:rgba(255,255,255,.65);font-size:.82rem;text-align:center;max-width:600px;line-height:1.5;"></p>
    </div>
</div>
<script>
function imgLb(srcOrEl, caption) {
    let src, cap;
    if (typeof srcOrEl === 'string') {
        src = srcOrEl; cap = caption || '';
    } else {
        src = srcOrEl.dataset.full || srcOrEl.src;
        cap = srcOrEl.dataset.caption || srcOrEl.alt || '';
    }
    document.getElementById('imgLbImg').src = src;
    document.getElementById('imgLbImg').alt = cap;
    document.getElementById('imgLbCaption').textContent = cap;
    document.getElementById('imgLbFull').href = src;
    const ov = document.getElementById('imgLbOverlay');
    ov.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeLb(e) {
    if (e && e.currentTarget && e.currentTarget.id === 'imgLbOverlay' && e.target !== e.currentTarget) return;
    document.getElementById('imgLbOverlay').style.display = 'none';
    document.getElementById('imgLbImg').src = '';
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') { document.getElementById('imgLbOverlay').style.display = 'none'; document.body.style.overflow = ''; } });
</script>
<script>
function toggleDesc(id, btn) {
    const el = document.getElementById(id);
    if (!el) return;
    el.classList.toggle('expanded');
    const isExpanded = el.classList.contains('expanded');
    btn.innerHTML = isExpanded
        ? 'Read Less <i class="fas fa-chevron-up text-[10px]"></i>'
        : 'Read More <i class="fas fa-chevron-down text-[10px]"></i>';
}
</script>
</body>
</html>
