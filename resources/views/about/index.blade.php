@extends('layouts.app')
@section('title', 'About Us — '.$siteName)
@section('meta_desc', 'Learn about '.$siteName.' — a 12A & 80G registered NGO inspired by Maharaj-ji. Dedicated to feeding the hungry, educating children, and providing healthcare across India.')
@section('meta_keywords', 'about NKB Foundation, '.$siteName.' about, NGO India about, Maharaj-ji foundation, 12A 80G NGO India, NKB Foundation history, charitable trust India')
@section('canonical', route('about'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "AboutPage",
  "name": "About Us — {{ $siteName }}",
  "description": "About NKB Foundation — 12A & 80G registered NGO inspired by Maharaj-ji's teachings of love and seva.",
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
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">About Us</h1>
        <p class="text-purple-200">{{ $siteName }}</p>
        <nav class="flex mt-3 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">About Us</span>
        </nav>
    </div>
</div>

{{-- About intro section --}}
<section class="py-16 px-4" style="background:linear-gradient(135deg,#0C0920 0%,#1a0f3c 100%);">
    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

            {{-- Left: text --}}
            <div class="text-white">
                <span style="color:#F97316;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;">Our Story</span>
                <h2 style="font-size:clamp(1.6rem,3.5vw,2.4rem);font-weight:900;line-height:1.15;margin:.5rem 0 1.25rem;">
                    About <span style="background:linear-gradient(90deg,#F97316,#FCD34D);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">{{ $siteName }}</span>
                </h2>
                <p style="color:rgba(255,255,255,.78);font-size:.95rem;line-height:1.85;margin-bottom:1.5rem;">
                    The {{ $siteName }} is more than an organization; it is a lifeline for underserved communities in rural Maharashtra. Our mission is simple yet profound: to replace hardship with hope. Through dedicated initiatives in health and learning, we empower individuals to break the cycle of poverty and claim their dignity.
                </p>
                <p style="color:rgba(255,255,255,.68);font-size:.9rem;line-height:1.8;">
                    We believe in holistic development and work hand-in-hand with generous supporters to drive lasting, positive change. Rooted in compassion, our work ensures that essential resources reach the hands that need them most, creating a world united by service.
                </p>

                <div style="display:flex;gap:1.5rem;flex-wrap:wrap;margin-top:2rem;">
                    <div style="text-align:center;">
                        <div style="font-size:1.8rem;font-weight:900;color:#F97316;">12A</div>
                        <div style="color:rgba(255,255,255,.5);font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;">Certified</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,.1);"></div>
                    <div style="text-align:center;">
                        <div style="font-size:1.8rem;font-weight:900;color:#F97316;">80G</div>
                        <div style="color:rgba(255,255,255,.5);font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;">Tax Exempt</div>
                    </div>
                    <div style="width:1px;background:rgba(255,255,255,.1);"></div>
                    <div style="text-align:center;">
                        <div style="font-size:1.8rem;font-weight:900;color:#F97316;">2025</div>
                        <div style="color:rgba(255,255,255,.5);font-size:.7rem;text-transform:uppercase;letter-spacing:.08em;">Registered</div>
                    </div>
                </div>
            </div>

            {{-- Right: registration card --}}
            <div style="background:rgba(255,255,255,.04);border:1px solid rgba(249,115,22,.2);border-radius:20px;padding:2rem;backdrop-filter:blur(10px);">
                <h3 style="color:#F97316;font-size:1rem;font-weight:800;text-transform:uppercase;letter-spacing:.1em;margin-bottom:1.5rem;display:flex;align-items:center;gap:.5rem;">
                    <i class="fas fa-file-shield"></i> Registration Details
                </h3>
                @php
                $regDetails = [
                    ['NGO Type',            'Charitable Trust (Non-Government)'],
                    ['Governing Act',        'Indian Trust Act'],
                    ['Registration No.',     'E-4030-Co'],
                    ['City / State',         'Kolhapur, Maharashtra'],
                    ['Date of Registration', '10 November 2025'],
                    ['Niti Aayog Unique ID', 'MH/2026/1016757'],
                ];
                @endphp
                @foreach($regDetails as [$label, $value])
                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:1rem;
                            padding:.7rem 0;{{ !$loop->last ? 'border-bottom:1px solid rgba(255,255,255,.07);' : '' }}">
                    <span style="color:rgba(255,255,255,.45);font-size:.78rem;white-space:nowrap;flex-shrink:0;">{{ $label }}</span>
                    <span style="color:#fff;font-size:.82rem;font-weight:600;text-align:right;">{{ $value }}</span>
                </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

{{-- Sub-page navigation cards --}}
<div class="py-16 px-4 max-w-7xl mx-auto">
    <h3 class="text-center text-2xl font-bold text-gray-800 mb-8">Explore More About Us</h3>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <a href="{{ route('about.founders') }}" class="card-hover bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm hover:border-orange-300 group">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-orange-500 transition">
                <i class="fas fa-users text-orange-500 group-hover:text-white text-2xl transition"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-2">Founder Member</h3>
            <p class="text-gray-500 text-sm">Meet the dedicated individuals who founded this organisation.</p>
        </a>
        <a href="{{ route('about.org-profile') }}" class="card-hover bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm hover:border-orange-300 group">
            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-purple-700 transition">
                <i class="fas fa-building text-purple-700 group-hover:text-white text-2xl transition"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-2">Organisation Profile</h3>
            <p class="text-gray-500 text-sm">Learn about our registration, certifications, and legal details.</p>
        </a>
        <a href="{{ route('about.documents') }}" class="card-hover bg-white border border-gray-100 rounded-2xl p-8 text-center shadow-sm hover:border-orange-300 group">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-600 transition">
                <i class="fas fa-file-alt text-green-600 group-hover:text-white text-2xl transition"></i>
            </div>
            <h3 class="font-bold text-xl text-gray-900 mb-2">Document Gallery</h3>
            <p class="text-gray-500 text-sm">View and download our official certificates and documents.</p>
        </a>
    </div>
</div>
@endsection
