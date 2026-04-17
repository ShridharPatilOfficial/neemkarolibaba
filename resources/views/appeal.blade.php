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

        @if($appealImage)
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <img src="{{ str_starts_with($appealImage, 'http') ? $appealImage : asset('storage/' . $appealImage) }}"
                 alt="Appeal Letter — {{ $siteName }}"
                 class="w-full h-auto block">
        </div>

        <div class="mt-6 text-center">
            <a href="{{ str_starts_with($appealImage, 'http') ? $appealImage : asset('storage/' . $appealImage) }}"
               download target="_blank"
               class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition text-sm shadow-md">
                <i class="fas fa-download"></i> Download Appeal Letter
            </a>
        </div>

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
