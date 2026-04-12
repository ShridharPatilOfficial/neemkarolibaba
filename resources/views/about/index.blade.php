@extends('layouts.app')
@section('title', 'About Us — '.$siteName)
@section('meta_desc', 'Learn about '.$siteName.' — a registered charitable trust inspired by Maharaj-ji. Dedicated to health, education, and community service in rural Maharashtra.')
@section('meta_keywords', 'about NKB Foundation, '.$siteName.' about, NGO India about, Maharaj-ji foundation, charitable trust India, Kolhapur NGO')
@section('canonical', route('about'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "AboutPage",
  "name": "About Us — {{ $siteName }}",
  "description": "About NKB Foundation — a registered charitable trust inspired by Maharaj-ji's teachings of love and seva.",
  "url": "{{ route('about') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "About Us", "item": "{{ route('about') }}" }
    ]
  }
}
</script>
@endpush

@section('content')

{{-- Banner --}}
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag" style="color:#f97316">Our Story</span>
        <h1 class="text-4xl md:text-5xl font-black mt-1 mb-2">About Us</h1>
        <p class="text-purple-200 text-sm">Rooted in compassion — serving communities across rural Maharashtra.</p>
        <nav class="flex mt-3 text-sm items-center gap-1" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <span class="text-gray-300">About Us</span>
        </nav>
    </div>
</div>

{{-- ── Who We Are ─────────────────────────────────────────────────────── --}}
<section class="py-20 px-4" style="background:linear-gradient(135deg,#0C0920 0%,#150D35 100%);">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-start">

            {{-- Left: text --}}
            <div class="text-white">
                <span style="color:#F97316;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;display:block;margin-bottom:.5rem;">
                    <i class="fas fa-seedling mr-1"></i> Who We Are
                </span>
                <h2 style="font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:900;line-height:1.15;margin-bottom:1.5rem;">
                    About <span style="background:linear-gradient(90deg,#F97316,#FCD34D);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $siteName }}</span>
                </h2>

                <p style="color:rgba(255,255,255,.82);font-size:.95rem;line-height:1.9;margin-bottom:1.2rem;">
                    The {{ $siteName }} is more than an organization — it is a lifeline for underserved communities in rural Maharashtra. Our mission is simple yet profound: to replace hardship with hope. Through dedicated initiatives in health and learning, we empower individuals to break the cycle of poverty and claim their dignity.
                </p>
                <p style="color:rgba(255,255,255,.68);font-size:.9rem;line-height:1.85;margin-bottom:1.2rem;">
                    We believe in holistic development and work hand-in-hand with generous supporters to drive lasting, positive change. Rooted in compassion, our work ensures that essential resources reach the hands that need them most, creating a world united by service.
                </p>
                <p style="color:rgba(255,255,255,.68);font-size:.9rem;line-height:1.85;">
                    {{ $siteName }} is registered with the Sub-Registrar as a Charitable Trust (Non-Government) bearing the Indian Trust Act, operating from Kolhapur, Maharashtra. Our Unique ID from Niti Aayog is MH/2026/1016757.
                </p>

                {{-- Mission pillars --}}
                <div style="display:flex;flex-direction:column;gap:.85rem;margin-top:2rem;">
                    @php
                    $pillars = [
                        ['fas fa-heartbeat','#ef4444','Healthcare','Free health camps and medical support for rural communities.'],
                        ['fas fa-graduation-cap','#3b82f6','Education','Empowering children and youth with access to quality learning.'],
                        ['fas fa-hands-helping','#10b981','Community Seva','Feeding programmes, skill development, and livelihood support.'],
                    ];
                    @endphp
                    @foreach($pillars as [$icon,$color,$title,$desc])
                    <div style="display:flex;align-items:flex-start;gap:1rem;background:rgba(255,255,255,.04);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:1rem 1.2rem;">
                        <div style="width:40px;height:40px;border-radius:10px;background:{{ $color }}22;border:1px solid {{ $color }}44;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="{{ $icon }}" style="color:{{ $color }};font-size:.95rem;"></i>
                        </div>
                        <div>
                            <div style="color:#fff;font-weight:700;font-size:.85rem;margin-bottom:.2rem;">{{ $title }}</div>
                            <div style="color:rgba(255,255,255,.5);font-size:.78rem;line-height:1.55;">{{ $desc }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div style="margin-top:2rem;display:flex;gap:.85rem;flex-wrap:wrap;">
                    <a href="{{ route('about.founders') }}"
                       style="display:inline-flex;align-items:center;gap:.5rem;background:#F97316;color:#fff;font-weight:700;font-size:.82rem;padding:.7rem 1.5rem;border-radius:10px;text-decoration:none;transition:all .2s;">
                        <i class="fas fa-users text-sm"></i> Meet the Founders
                    </a>
                    <a href="{{ route('donate') }}"
                       style="display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,255,255,.08);border:1.5px solid rgba(255,255,255,.25);color:#fff;font-weight:600;font-size:.82rem;padding:.7rem 1.5rem;border-radius:10px;text-decoration:none;transition:all .2s;">
                        <i class="fas fa-heart text-orange-400 text-sm"></i> Donate Now
                    </a>
                </div>
            </div>

            {{-- Right: Organisation Profile card (dynamic from DB) --}}
            <div>
                <div style="background:rgba(255,255,255,.04);border:1px solid rgba(249,115,22,.22);border-radius:20px;padding:2rem;backdrop-filter:blur(10px);">
                    <h3 style="color:#F97316;font-size:.88rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;margin-bottom:1.5rem;display:flex;align-items:center;gap:.6rem;">
                        <i class="fas fa-file-shield"></i> Organisation Profile
                    </h3>

                    @if($profiles->count())
                        @foreach($profiles as $row)
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;
                                    padding:.75rem 0;{{ !$loop->last ? 'border-bottom:1px solid rgba(255,255,255,.07);' : '' }}">
                            <span style="color:rgba(255,255,255,.45);font-size:.78rem;white-space:nowrap;flex-shrink:0;padding-top:.05rem;">
                                {{ $row->document_name }}
                            </span>
                            <span style="color:#fff;font-size:.82rem;font-weight:600;text-align:right;">
                                {{ $row->value }}
                            </span>
                        </div>
                        @endforeach
                    @else
                    {{-- Fallback if no DB records --}}
                    @php
                    $fallback = [
                        ['NGO Type',            'Charitable Trust (Non-Government)'],
                        ['Governing Act',        'Indian Trust Act'],
                        ['Registration No.',     'E-4030-Co'],
                        ['City / State',         'Kolhapur, Maharashtra'],
                        ['Date of Registration', '10 November 2025'],
                        ['Niti Aayog Unique ID', 'MH/2026/1016757'],
                    ];
                    @endphp
                    @foreach($fallback as [$label, $val])
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;
                                padding:.75rem 0;{{ !$loop->last ? 'border-bottom:1px solid rgba(255,255,255,.07);' : '' }}">
                        <span style="color:rgba(255,255,255,.45);font-size:.78rem;white-space:nowrap;flex-shrink:0;">{{ $label }}</span>
                        <span style="color:#fff;font-size:.82rem;font-weight:600;text-align:right;">{{ $val }}</span>
                    </div>
                    @endforeach
                    @endif

                    <div style="margin-top:1.5rem;padding-top:1.2rem;border-top:1px solid rgba(249,115,22,.18);">
                        <a href="{{ route('about.org-profile') }}"
                           style="display:inline-flex;align-items:center;gap:.5rem;color:#F97316;font-size:.78rem;font-weight:700;text-decoration:none;text-transform:uppercase;letter-spacing:.06em;">
                            View Full Profile <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>

                {{-- Niti Aayog badge --}}
                <div style="margin-top:1rem;background:rgba(255,255,255,.03);border:1px solid rgba(255,255,255,.08);border-radius:14px;padding:1rem 1.2rem;display:flex;align-items:center;gap:.9rem;">
                    <div style="width:40px;height:40px;border-radius:10px;background:rgba(249,115,22,.12);border:1px solid rgba(249,115,22,.2);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fas fa-id-badge" style="color:#F97316;font-size:1rem;"></i>
                    </div>
                    <div>
                        <div style="color:rgba(255,255,255,.45);font-size:.68rem;text-transform:uppercase;letter-spacing:.08em;">Niti Aayog Unique ID</div>
                        <div style="color:#FCD34D;font-size:.9rem;font-weight:800;letter-spacing:.04em;">MH/2026/1016757</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ── Vision & Mission ────────────────────────────────────────────────── --}}
<section class="py-16 px-4 bg-white">
    <div class="max-w-6xl mx-auto text-center">
        <span class="section-tag">Our Purpose</span>
        <h2 class="text-3xl font-black text-gray-900 mt-1 mb-12">Vision &amp; <span class="text-orange-600">Mission</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-2xl p-8 text-left">
                <div class="w-14 h-14 bg-orange-500 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-eye text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Our Vision</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    A society where every individual — regardless of background or circumstance — has access to healthcare, education, and dignity. We envision communities transformed by compassion, seva, and the timeless teachings of Neem Karoli Baba.
                </p>
            </div>
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 rounded-2xl p-8 text-left">
                <div class="w-14 h-14 bg-purple-700 rounded-xl flex items-center justify-center mb-4">
                    <i class="fas fa-bullseye text-white text-xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Our Mission</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    To replace hardship with hope by delivering targeted, sustainable programmes in healthcare, education, and community support — working hand-in-hand with generous supporters to ensure essential resources reach the hands that need them most.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ── Explore More ─────────────────────────────────────────────────────── --}}
<section class="py-16 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-10">
            <span class="section-tag">Explore</span>
            <h2 class="text-2xl font-black text-gray-900 mt-1">More About <span class="text-orange-600">Us</span></h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="{{ route('about.founders') }}" class="group bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm hover:shadow-lg hover:border-orange-300 transition-all duration-300">
                <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-500 transition-colors duration-300">
                    <i class="fas fa-users text-orange-500 group-hover:text-white text-2xl transition-colors duration-300"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2">Founder Members</h3>
                <p class="text-gray-500 text-sm">Meet the dedicated individuals who founded this organisation.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-orange-600 text-xs font-bold">
                    View Members <i class="fas fa-arrow-right text-[10px]"></i>
                </span>
            </a>
            <a href="{{ route('about.org-profile') }}" class="group bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm hover:shadow-lg hover:border-purple-300 transition-all duration-300">
                <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-700 transition-colors duration-300">
                    <i class="fas fa-building text-purple-700 group-hover:text-white text-2xl transition-colors duration-300"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2">Organisation Profile</h3>
                <p class="text-gray-500 text-sm">Our full registration details, certifications, and legal information.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-purple-700 text-xs font-bold">
                    View Profile <i class="fas fa-arrow-right text-[10px]"></i>
                </span>
            </a>
            <a href="{{ route('about.documents') }}" class="group bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm hover:shadow-lg hover:border-green-300 transition-all duration-300">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition-colors duration-300">
                    <i class="fas fa-file-alt text-green-600 group-hover:text-white text-2xl transition-colors duration-300"></i>
                </div>
                <h3 class="font-bold text-lg text-gray-900 mb-2">Document Gallery</h3>
                <p class="text-gray-500 text-sm">View and download our official certificates and documents.</p>
                <span class="mt-4 inline-flex items-center gap-1 text-green-600 text-xs font-bold">
                    View Documents <i class="fas fa-arrow-right text-[10px]"></i>
                </span>
            </a>
        </div>
    </div>
</section>

@endsection
