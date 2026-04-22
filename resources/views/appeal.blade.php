@extends('layouts.app')
@section('title', 'Appeal Letter — '.$siteName)
@section('meta_desc', 'Read the public appeal letter from '.$siteName.' — a heartfelt message from our President seeking your support for education, healthcare and community service.')
@section('canonical', route('appeal'))

@section('content')

<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag" style="color:#f97316">Support Us</span>
        <h1 class="text-4xl md:text-5xl font-black mt-1 mb-2">Appeal Letter</h1>
        <p class="text-purple-200 text-sm">A message from our President — your support can change lives.</p>
        <nav class="flex mt-3 text-sm items-center gap-1" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <span class="text-gray-300">Appeal Letter</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4 bg-gray-50">
    <div class="max-w-3xl mx-auto">

        @php
            $appealEn = $appealImage ?? null;
            $appealMr = \App\Models\SiteSetting::get('appeal_image_mr');
            $hasBoth  = $appealEn && $appealMr;
        @endphp

        @if($appealEn || $appealMr)

        {{-- Language tabs (only if both exist) --}}
        @if($hasBoth)
        <div class="flex gap-2 mb-6 justify-center">
            <button id="tab-en" onclick="switchTab('en')"
                    class="px-6 py-2 rounded-xl font-bold text-sm transition border-2 border-orange-400 bg-orange-500 text-white">
                English
            </button>
            <button id="tab-mr" onclick="switchTab('mr')"
                    class="px-6 py-2 rounded-xl font-bold text-sm transition border-2 border-gray-200 bg-white text-gray-600 hover:border-purple-400 hover:text-purple-700">
                मराठी
            </button>
        </div>
        @endif

        {{-- English image --}}
        @if($appealEn)
        <div id="panel-en">
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <img src="{{ str_starts_with($appealEn, 'http') ? $appealEn : asset('storage/' . $appealEn) }}"
                     alt="Appeal Letter (English) — {{ $siteName }}"
                     class="w-full h-auto block">
            </div>
            <div class="mt-6 text-center">
                <a href="{{ str_starts_with($appealEn, 'http') ? $appealEn : asset('storage/' . $appealEn) }}"
                   download target="_blank"
                   class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition text-sm shadow-md">
                    <i class="fas fa-download"></i> Download (English)
                </a>
            </div>
        </div>
        @endif

        {{-- Marathi image --}}
        @if($appealMr)
        <div id="panel-mr" {{ $hasBoth ? 'style=display:none' : '' }}>
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <img src="{{ str_starts_with($appealMr, 'http') ? $appealMr : asset('storage/' . $appealMr) }}"
                     alt="Appeal Letter (Marathi) — {{ $siteName }}"
                     class="w-full h-auto block">
            </div>
            <div class="mt-6 text-center">
                <a href="{{ str_starts_with($appealMr, 'http') ? $appealMr : asset('storage/' . $appealMr) }}"
                   download target="_blank"
                   class="inline-flex items-center gap-2 bg-purple-700 hover:bg-purple-800 text-white font-bold py-3 px-8 rounded-xl transition text-sm shadow-md">
                    <i class="fas fa-download"></i> डाउनलोड करा (मराठी)
                </a>
            </div>
        </div>
        @endif

        @else
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-16 text-center">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-envelope-open-text text-orange-500 text-2xl"></i>
            </div>
            <p class="text-gray-400 text-sm">Appeal letter image will appear here once uploaded by admin.</p>
        </div>
        @endif

        <div class="mt-10 bg-orange-50 border border-orange-200 rounded-2xl p-6 text-center">
            <p class="text-gray-700 text-sm leading-relaxed mb-4">
                Your generous contribution helps us continue our mission of compassion, education and healthcare for the underprivileged.
            </p>
            <a href="{{ route('donate') }}#payment-section"
               class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition text-sm">
                <i class="fas fa-heart"></i> Donate Now
            </a>
        </div>

    </div>
</section>

@endsection

@push('scripts')
<script>
function switchTab(lang) {
    var enPanel = document.getElementById('panel-en');
    var mrPanel = document.getElementById('panel-mr');
    var enTab   = document.getElementById('tab-en');
    var mrTab   = document.getElementById('tab-mr');
    if (!enPanel || !mrPanel) return;

    if (lang === 'en') {
        enPanel.style.display = '';
        mrPanel.style.display = 'none';
        enTab.className = 'px-6 py-2 rounded-xl font-bold text-sm transition border-2 border-orange-400 bg-orange-500 text-white';
        mrTab.className = 'px-6 py-2 rounded-xl font-bold text-sm transition border-2 border-gray-200 bg-white text-gray-600 hover:border-purple-400 hover:text-purple-700';
    } else {
        enPanel.style.display = 'none';
        mrPanel.style.display = '';
        mrTab.className = 'px-6 py-2 rounded-xl font-bold text-sm transition border-2 border-purple-500 bg-purple-700 text-white';
        enTab.className = 'px-6 py-2 rounded-xl font-bold text-sm transition border-2 border-gray-200 bg-white text-gray-600 hover:border-orange-400 hover:text-orange-600';
    }
}
</script>
@endpush
