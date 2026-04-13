@extends('layouts.app')
@section('title', 'Objectives of the Trust — '.$siteName)
@section('meta_desc', 'Read the 23 core objectives of '.$siteName.' — covering healthcare, education, women\'s empowerment, disaster relief, sports, art, culture, and community seva.')
@section('canonical', route('about.objectives'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Objectives of the Trust — {{ $siteName }}",
  "url": "{{ route('about.objectives') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home",     "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "About Us", "item": "{{ route('about') }}" },
      { "@@type": "ListItem", "position": 3, "name": "Objectives of the Trust", "item": "{{ route('about.objectives') }}" }
    ]
  }
}
</script>
@endpush

@push('styles')
<style>
.obj-card {
    opacity: 0;
    transition: opacity 0.65s cubic-bezier(.22,.68,0,1.15),
                transform 0.65s cubic-bezier(.22,.68,0,1.15),
                box-shadow 0.35s ease,
                border-color 0.35s ease;
    position: relative;
    overflow: hidden;
}
.anim-fadeup    { transform: translateY(50px); }
.anim-fadeleft  { transform: translateX(60px) rotate(1.5deg); }
.anim-zoom      { transform: scale(0.82) translateY(20px); }
.anim-faderight { transform: translateX(-60px) rotate(-1.5deg); }
.anim-flipup    { transform: perspective(700px) rotateX(22deg) translateY(35px); }
.anim-bounce    { transform: translateY(45px) scale(0.95); transition-timing-function: cubic-bezier(.34,1.56,.64,1); }

.obj-card.animate-in {
    opacity: 1;
    transform: none !important;
}
.obj-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 4px;
    background: linear-gradient(90deg, #f97316 0%, #fcd34d 50%, #fb923c 100%);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.45s cubic-bezier(.22,.68,0,1.2);
    z-index: 2;
    border-radius: 4px 4px 0 0;
}
.obj-card:hover::before { transform: scaleX(1); }
.obj-card::after {
    content: '';
    position: absolute;
    inset: 0;
    background: radial-gradient(ellipse at top left, rgba(249,115,22,0.06) 0%, transparent 65%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
    z-index: 0;
}
.obj-card:hover::after { opacity: 1; }
.obj-card:hover {
    transform: translateY(-8px) scale(1.015) !important;
    box-shadow: 0 24px 48px rgba(249,115,22,0.13), 0 8px 20px rgba(0,0,0,0.09), 0 0 0 1.5px #fdba74 !important;
    border-color: transparent !important;
}
.obj-num {
    transition: transform 0.35s cubic-bezier(.34,1.56,.64,1), box-shadow 0.3s ease;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
}
.obj-card:hover .obj-num {
    transform: scale(1.25) rotate(-8deg);
    box-shadow: 0 6px 18px rgba(249,115,22,0.45);
}
.obj-card-body { position: relative; z-index: 1; }
.obj-title {
    background-image: linear-gradient(90deg, #f97316, #fcd34d);
    background-size: 0% 2px;
    background-repeat: no-repeat;
    background-position: 0 100%;
    transition: background-size 0.4s ease;
    padding-bottom: 2px;
    display: inline;
}
.obj-card:hover .obj-title { background-size: 100% 2px; }
.obj-img { transition: transform 0.55s cubic-bezier(.22,.68,0,1.1); }
.obj-card:hover .obj-img { transform: scale(1.06); }
.obj-card:nth-child(6n+1) .obj-num { background: linear-gradient(135deg,#f97316,#fb923c) !important; }
.obj-card:nth-child(6n+2) .obj-num { background: linear-gradient(135deg,#8b5cf6,#7c3aed) !important; }
.obj-card:nth-child(6n+3) .obj-num { background: linear-gradient(135deg,#0ea5e9,#2563eb) !important; }
.obj-card:nth-child(6n+4) .obj-num { background: linear-gradient(135deg,#10b981,#059669) !important; }
.obj-card:nth-child(6n+5) .obj-num { background: linear-gradient(135deg,#ec4899,#db2777) !important; }
.obj-card:nth-child(6n+6) .obj-num { background: linear-gradient(135deg,#f59e0b,#d97706) !important; }
.obj-ribbon {
    position: absolute;
    top: 14px; right: -28px;
    width: 90px;
    padding: 3px 0;
    background: linear-gradient(90deg,#f97316,#fcd34d);
    color: #7c2d12;
    font-size: 10px;
    font-weight: 900;
    text-align: center;
    transform: rotate(45deg);
    letter-spacing: .05em;
    z-index: 3;
    box-shadow: 0 2px 8px rgba(249,115,22,.3);
}
</style>
@endpush

@section('content')

{{-- Banner --}}
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag" style="color:#f97316">About Us</span>
        <h1 class="text-4xl md:text-5xl font-black mt-1 mb-2">Objectives of the Trust</h1>
        <p class="text-purple-200 text-sm">Our guiding purposes — the principles that drive every programme and initiative.</p>
        <nav class="flex mt-3 text-sm items-center gap-1 flex-wrap" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <a href="{{ route('about') }}" class="text-orange-400 hover:underline">About Us</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <span class="text-gray-300">Objectives</span>
        </nav>
    </div>
</div>

{{-- Intro strip --}}
<div style="background:linear-gradient(135deg,#0C0920 0%,#150D35 100%);padding:2.5rem 1rem;">
    <div class="max-w-4xl mx-auto text-center">
        <p style="color:rgba(255,255,255,.75);font-size:.95rem;line-height:1.9;max-width:750px;margin:0 auto;">
            The {{ $siteName }} was established with a broad, people-first mandate — from healthcare and education to cultural preservation, environmental protection, and disaster relief. Below are the <strong style="color:#FCD34D;">{{ $objectives->count() }} core objectives</strong> that guide our work.
        </p>
    </div>
</div>

{{-- Objectives list --}}
<section class="py-16 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">

        @if($objectives->count())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($objectives as $i => $obj)
            @php
                $animClasses = ['anim-fadeup','anim-fadeleft','anim-zoom','anim-faderight','anim-flipup','anim-bounce'];
                $anim = $animClasses[$loop->index % count($animClasses)];
                $delay = ($loop->index % 2) * 100;
            @endphp
            <div class="obj-card {{ $anim }} bg-white rounded-2xl border border-gray-100 shadow-sm flex flex-col relative"
                 style="transition-delay: {{ $delay }}ms;">

                {{-- Corner ribbon --}}
                <div class="obj-ribbon">0{{ $loop->iteration }}</div>

                {{-- Optional image --}}
                @if($obj->image_url)
                <div class="relative overflow-hidden" style="height:210px;">
                    <img src="{{ $obj->image_url }}" alt="{{ $obj->title }}"
                         class="obj-img w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <div class="obj-num absolute top-3 left-3 w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                        <span class="text-white font-black text-sm">{{ $loop->iteration }}</span>
                    </div>
                </div>
                @endif

                <div class="obj-card-body p-6 flex flex-col flex-1">
                    <div class="flex items-start gap-3 mb-3">
                        @if(!$obj->image_url)
                        <div class="obj-num w-10 h-10 rounded-full bg-orange-500 flex items-center justify-center shadow-md">
                            <span class="text-white font-black text-sm">{{ $loop->iteration }}</span>
                        </div>
                        @endif
                        <h3 class="obj-title font-bold text-gray-900 text-base leading-snug pt-1">{{ $obj->title }}</h3>
                    </div>
                    <div class="text-gray-500 text-sm leading-relaxed rich-text flex-1">
                        {!! $obj->description !!}
                    </div>
                </div>

            </div>
            @endforeach
        </div>

        @else
        <div class="text-center py-24">
            <div class="w-20 h-20 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-list-ul text-orange-400 text-3xl"></i>
            </div>
            <p class="text-gray-500 text-lg font-medium">Objectives coming soon</p>
            <p class="text-gray-400 text-sm mt-1">Check back shortly — our team is adding the trust objectives.</p>
        </div>
        @endif

    </div>
</section>

{{-- CTA strip --}}
<section class="py-14 px-4" style="background:linear-gradient(135deg,#0C0920 0%,#150D35 100%);">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-2xl font-black text-white mb-3">Be Part of <span style="background:linear-gradient(90deg,#F97316,#FCD34D);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Our Mission</span></h2>
        <p class="text-purple-300 text-sm mb-6">Your support directly funds these objectives — from health camps to educational scholarships.</p>
        <div class="flex justify-center gap-3 flex-wrap">
            <a href="{{ route('donate') }}" class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-7 rounded-xl transition shadow-lg text-sm">
                <i class="fas fa-heart"></i> Donate Now
            </a>
            <a href="{{ route('about') }}" class="inline-flex items-center gap-2 border border-white/25 text-white hover:bg-white/10 font-semibold py-3 px-7 rounded-xl transition text-sm">
                <i class="fas fa-arrow-left text-xs"></i> Back to About
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
const cards = document.querySelectorAll('.obj-card');
const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            e.target.classList.add('animate-in');
            io.unobserve(e.target);
        }
    });
}, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });
cards.forEach(card => io.observe(card));
</script>
@endpush