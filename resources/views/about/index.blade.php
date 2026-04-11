@extends('layouts.app')
@section('title', 'About Us — '.$siteName)
@section('meta_desc', 'Learn about {{ $siteName }} — a 12A & 80G registered NGO inspired by Maharaj-ji. Dedicated to feeding the hungry, educating children, and providing healthcare across India.')
@section('meta_keywords', 'about NKB Foundation, {{ $siteName }} about, NGO India about, Maharaj-ji foundation, 12A 80G NGO India, NKB Foundation history, charitable trust India')
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

<div class="py-16 px-4 max-w-7xl mx-auto">
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
