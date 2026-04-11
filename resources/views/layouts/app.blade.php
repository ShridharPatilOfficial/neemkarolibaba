<!DOCTYPE html>
<html lang="en" prefix="og: https://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $metaTitle = trim(strip_tags(\Illuminate\Support\Str::limit(
            $__env->yieldContent('title') ?: 'Neem Karoli Baba Foundation Worldwide', 60
        )));
        $metaDesc  = trim(strip_tags(
            $__env->yieldContent('meta_desc') ?: 'Neem Karoli Baba Foundation Worldwide – serving humanity through education, healthcare & community welfare inspired by Neem Karoli Baba (Maharaj-ji). 12A & 80G registered NGO in India.'
        ));
        $metaImg   = $__env->yieldContent('og_image') ?: asset('images/og-default.jpg');
        $canonical = $__env->yieldContent('canonical') ?: url()->current();
        $siteName  = \App\Models\SiteSetting::get('site_name', 'Neem Karoli Baba Foundation Worldwide');
    @endphp

    {{-- Primary --}}
    <title>{{ $metaTitle }}</title>
    <meta name="description"  content="{{ $metaDesc }}">
    <meta name="keywords"     content="@yield('meta_keywords', 'Neem Karoli Baba Foundation, NKB Foundation, NGO India, Maharaj-ji, charity, donate India, 80G registered')">
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

    {{-- Favicon --}}
    <link rel="icon"             href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <link rel="shortcut icon"    href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.svg') }}">

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
      "logo": "{{ asset('favicon.svg') }}",
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

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    @stack('styles')
</head>
<body class="font-sans antialiased bg-white text-gray-800 overflow-x-hidden">

{{-- ─── Top Info Bar ─────────────────────────────────────────────── --}}
<div class="bg-purple-950 text-purple-200 text-xs py-2 px-4 hidden md:block">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
        <div class="flex items-center gap-5">
            <a href="mailto:{{ \App\Models\SiteSetting::get('email', 'info@nkbfoundation.org') }}"
               class="flex items-center gap-1.5 hover:text-orange-400 transition">
                <i class="fas fa-envelope text-orange-400"></i>
                {{ \App\Models\SiteSetting::get('email', 'info@nkbfoundation.org') }}
            </a>
            <a href="tel:{{ \App\Models\SiteSetting::get('phone', '+919876543210') }}"
               class="flex items-center gap-1.5 hover:text-orange-400 transition">
                <i class="fas fa-phone text-orange-400"></i>
                {{ \App\Models\SiteSetting::get('phone', '+91 98765 43210') }}
            </a>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-purple-400">|</span>
            <span class="text-purple-300">Reg. No: {{ \App\Models\SiteSetting::get('reg_no', 'XXXXXX/2024') }}</span>
            <span class="text-purple-400">|</span>
            @foreach(['facebook','instagram','youtube'] as $social)
            @php $url = \App\Models\SiteSetting::get($social, '#'); @endphp
            <a href="{{ $url }}" target="_blank" rel="noopener"
               class="w-6 h-6 rounded-full bg-purple-800 hover:bg-orange-500 flex items-center justify-center transition">
                <i class="fab fa-{{ $social }} text-[10px]"></i>
            </a>
            @endforeach
        </div>
    </div>
</div>

{{-- ─── Main Header ──────────────────────────────────────────────── --}}
<header class="bg-yellow-400 py-3 px-4 shadow-sm">
    <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-3">
        <div class="flex items-center gap-3">
            <img src="{{ asset('favicon.svg') }}" alt="NKB Om Logo" class="w-14 h-14 rounded-full shadow-md flex-shrink-0">
            <div>
                <h1 class="text-purple-900 font-extrabold text-lg md:text-xl leading-tight">
                    {{ \App\Models\SiteSetting::get('site_name', 'Neem Karoli Baba Foundation Worldwide') }}
                </h1>
                <p class="text-purple-700 text-xs font-semibold flex items-center gap-1">
                    <i class="fas fa-shield-halved"></i>
                    {{ \App\Models\SiteSetting::get('site_tagline', 'Love All, Serve All') }}
                </p>
            </div>
        </div>
        <a href="{{ route('donate') }}#payment-section" class="donate-btn" style="padding:10px 24px;border-radius:12px;font-size:.85rem;display:inline-flex;align-items:center;gap:8px;flex-shrink:0;">
            <i class="fas fa-heart btn-heart"></i>
            DONATE US
        </a>
    </div>
</header>

{{-- ─── Navigation ──────────────────────────────────────────────── --}}
<nav id="main-nav" class="bg-purple-900 sticky top-0 z-50 transition-shadow duration-300">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-14">

            {{-- Desktop links --}}
            <ul class="hidden lg:flex items-center w-full">
                @php
                    $navLinks = [
                        ['label' => 'Home',           'route' => 'home',         'match' => 'home'],
                        ['label' => 'Our Activities', 'route' => 'activities',   'match' => 'activities'],
                        ['label' => 'Events',         'route' => 'events',       'match' => 'events'],
                        ['label' => 'Future Plan',    'route' => 'future-plan',  'match' => 'future-plan'],
                        ['label' => 'Join Us',        'route' => 'join-us',      'match' => 'join-us'],
                        ['label' => 'Contact Us',     'route' => 'contact',      'match' => 'contact'],
                        ['label' => 'Donate Us',      'route' => 'donate',       'match' => 'donate'],
                    ];
                @endphp

                <li><a href="{{ route('home') }}" class="block px-3 py-4 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-orange-400' : 'text-white hover:text-orange-300' }}">Home</a></li>

                {{-- About Us dropdown --}}
                <li class="nav-dropdown">
                    <button class="flex items-center gap-1 px-3 py-4 text-sm font-medium transition {{ request()->routeIs('about*') ? 'text-orange-400' : 'text-white hover:text-orange-300' }}">
                        About Us <i class="fas fa-chevron-down text-[10px] mt-0.5"></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('about.founders') }}">Founder Member</a>
                        <a href="{{ route('about.org-profile') }}">Organisation Profile</a>
                        <a href="{{ route('about.documents') }}">Document Gallery</a>
                    </div>
                </li>

                {{-- Media dropdown --}}
                <li class="nav-dropdown">
                    <button class="flex items-center gap-1 px-3 py-4 text-sm font-medium transition {{ request()->routeIs('media*') ? 'text-orange-400' : 'text-white hover:text-orange-300' }}">
                        Media <i class="fas fa-chevron-down text-[10px] mt-0.5"></i>
                    </button>
                    <div class="nav-dropdown-menu">
                        <a href="{{ route('gallery') }}">Photo & Video Gallery</a>
                        <a href="{{ route('media-coverage') }}">Media Coverage</a>
                    </div>
                </li>

                @foreach($navLinks as $nl)
                @if($nl['route'] !== 'home')
                @php $href = $nl['route'] === 'donate' ? route('donate').'#payment-section' : route($nl['route']); @endphp
                <li><a href="{{ $href }}" class="block px-3 py-4 text-sm font-medium transition {{ request()->routeIs($nl['match']) ? 'text-orange-400' : 'text-white hover:text-orange-300' }}">{{ $nl['label'] }}</a></li>
                @endif
                @endforeach
            </ul>

            {{-- Mobile hamburger --}}
            <button id="nav-toggle" class="lg:hidden text-white p-2 ml-auto" aria-label="Menu">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div id="mobile-menu" class="hidden lg:hidden border-t border-purple-700 pb-4 pt-2">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-white hover:text-orange-400 py-2 px-3 text-sm">
                <i class="fas fa-home w-4 text-orange-400"></i> Home
            </a>
            <div class="py-1 px-3">
                <p class="text-purple-400 text-xs font-semibold uppercase tracking-wider mb-1">About Us</p>
                <a href="{{ route('about.founders') }}" class="flex items-center gap-2 text-white hover:text-orange-400 py-1.5 px-3 text-sm">
                    <i class="fas fa-users w-4 text-orange-400"></i> Founder Member
                </a>
                <a href="{{ route('about.org-profile') }}" class="flex items-center gap-2 text-white hover:text-orange-400 py-1.5 px-3 text-sm">
                    <i class="fas fa-building w-4 text-orange-400"></i> Organisation Profile
                </a>
                <a href="{{ route('about.documents') }}" class="flex items-center gap-2 text-white hover:text-orange-400 py-1.5 px-3 text-sm">
                    <i class="fas fa-file w-4 text-orange-400"></i> Document Gallery
                </a>
            </div>
            @foreach([
                ['Our Activities','activities','fa-hands-helping'],
                ['Events','events','fa-calendar-days'],
                ['Future Plan','future-plan','fa-rocket'],
                ['Join Us','join-us','fa-user-plus'],
                ['Gallery','gallery','fa-images'],
                ['Media Coverage','media-coverage','fa-newspaper'],
                ['Contact Us','contact','fa-envelope'],
                ['Donate Us','donate','fa-heart'],
            ] as [$label, $route, $icon])
            @php $mHref = $route === 'donate' ? route('donate').'#payment-section' : route($route); @endphp
            <a href="{{ $mHref }}" class="flex items-center gap-2 text-white hover:text-orange-400 py-2 px-3 text-sm">
                <i class="fas {{ $icon }} w-4 text-orange-400"></i> {{ $label }}
            </a>
            @endforeach
        </div>
    </div>
</nav>

{{-- ─── Ticker ──────────────────────────────────────────────────── --}}
<div class="bg-emerald-700 text-white py-1.5 overflow-hidden text-xs">
    <div class="ticker-wrap">
        <div class="ticker-content font-medium">
            <i class="fas fa-bullhorn text-yellow-300 mr-3"></i>
            {{ \App\Models\SiteSetting::get('ticker_text', 'All donations are eligible for tax exemption — 12A & 80G CSR Registered Organisation. Support Neem Karoli Baba Foundation Worldwide today!') }}
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <i class="fas fa-hand-holding-heart text-yellow-300 mr-3"></i>
            {{ \App\Models\SiteSetting::get('ticker_text', 'Love All, Serve All — Join us in our mission of compassion and service') }}
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
                <img src="{{ asset('favicon.svg') }}" alt="NKB Om Logo" class="w-16 h-16 rounded-xl shadow-lg flex-shrink-0">
                <div>
                    <p class="font-bold text-lg leading-tight">{{ \App\Models\SiteSetting::get('site_name', 'Neem Karoli Baba Foundation') }}</p>
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
            <p>&copy; {{ date('Y') }} {{ \App\Models\SiteSetting::get('site_name', 'Neem Karoli Baba Foundation Worldwide') }}. All Rights Reserved.</p>
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
</body>
</html>
