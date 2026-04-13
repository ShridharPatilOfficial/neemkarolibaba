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
    transform: translateY(40px);
    transition: opacity 0.6s ease, transform 0.6s ease, box-shadow 0.3s ease, border-color 0.3s ease;
}
.obj-card.animate-in { opacity: 1; transform: translateY(0); }

/* Card 1 — fade up */
.anim-fadeup   { transition-timing-function: cubic-bezier(.22,.68,0,1.2); }
/* Card 2 — fade left */
.anim-fadeleft { transform: translateX(50px); }
.anim-fadeleft.animate-in { transform: translateX(0); }
/* Card 3 — zoom in */
.anim-zoom     { transform: scale(0.85); opacity: 0; }
.anim-zoom.animate-in { transform: scale(1); opacity: 1; }
/* Card 4 — fade right */
.anim-faderight { transform: translateX(-50px); }
.anim-faderight.animate-in { transform: translateX(0); }
/* Card 5 — flip up */
.anim-flipup   { transform: perspective(600px) rotateX(20deg) translateY(30px); opacity: 0; }
.anim-flipup.animate-in { transform: perspective(600px) rotateX(0deg) translateY(0); opacity: 1; }
/* Card 6 — bounce */
.anim-bounce   { transition-timing-function: cubic-bezier(.34,1.56,.64,1); }

.obj-card:hover {
    transform: translateY(-6px) scale(1.01) !important;
    box-shadow: 0 20px 40px rgba(249,115,22,0.12), 0 4px 16px rgba(0,0,0,0.08) !important;
    border-color: #fdba74 !important;
}

/* Number badge pulse on hover */
.obj-card:hover .obj-num {
    animation: badgePop 0.4s cubic-bezier(.34,1.56,.64,1) forwards;
}
@keyframes badgePop {
    0%   { transform: scale(1); }
    50%  { transform: scale(1.3) rotate(-8deg); }
    100% { transform: scale(1.1); }
}

/* Shimmer line at top of each card */
.obj-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: 2px 2px 0 0;
    background: linear-gradient(90deg, #f97316, #fcd34d, #fb923c);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.4s ease;
}
.obj-card:hover::before { transform: scaleX(1); }
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
    $delay = ($loop->index % 2) * 100; // stagger left/right columns
@endphp
<div class="obj-card {{ $anim }} bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col relative"
     style="transition-delay: {{ $delay }}ms;">

                {{-- Optional image --}}
                @if($obj->image_url)
                <div class="relative overflow-hidden" style="height:200px;">
                    <img src="{{ $obj->image_url }}" alt="{{ $obj->title }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                    {{-- Number badge on image --}}
                    <div class="absolute top-3 left-3 w-9 h-9 rounded-full bg-orange-500 flex items-center justify-center shadow-lg">
                        <span class="text-white font-black text-sm">{{ $loop->iteration }}</span>
                    </div>
                </div>
                @endif

                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-start gap-3 mb-3">
                        {{-- Number badge (when no image) --}}
                        @if(!$obj->image_url)
                        <div class="w-9 h-9 rounded-full bg-orange-500 flex items-center justify-center flex-shrink-0 shadow">
                            <span class="text-white font-black text-sm">{{ $loop->iteration }}</span>
                        </div>
                        @endif
                        <h3 class="font-bold text-gray-900 text-base leading-snug pt-1">{{ $obj->title }}</h3>
                    </div>
                    <div class="text-gray-600 text-sm leading-relaxed rich-text flex-1">
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
