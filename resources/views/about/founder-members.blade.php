@extends('layouts.app')
@section('title', 'Founder Members — '.$siteName)
@section('meta_desc', 'Meet the founder members and trustees of '.$siteName.' — dedicated individuals committed to Maharaj-ji\'s vision of selfless service and love for all.')
@section('meta_keywords', 'NKB Foundation founders, '.$siteName.' trustees, NGO founders India, NKB Foundation team, foundation members, charity trustees India')
@section('canonical', route('about.founders'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Founder Members — {{ $siteName }}",
  "url": "{{ route('about.founders') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "About", "item": "{{ route('about') }}" },
      { "@@type": "ListItem", "position": 3, "name": "Founder Members", "item": "{{ route('about.founders') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Founder Member</h1>
        <p class="text-purple-200">{{ $siteName }}</p>
        <nav class="flex mt-3 text-sm" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('about') }}" class="text-orange-400 hover:underline">About Us</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">Founder Member</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto">
        @if($members->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($members as $member)
            <div class="card-hover bg-white border border-gray-100 rounded-2xl p-6 text-center shadow-sm hover:shadow-lg hover:border-orange-200 transition-all duration-300 flex flex-col">
                <div class="w-32 h-32 mx-auto mb-4 rounded-xl overflow-hidden border-2 border-gray-200 bg-gray-100">
                    @if($member->photo_url)
                        <img src="{{ str_starts_with($member->photo_url, 'http') ? $member->photo_url : asset('storage/' . $member->photo_url) }}"
                             alt="{{ $member->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-purple-100">
                            <i class="fas fa-user text-purple-400 text-4xl"></i>
                        </div>
                    @endif
                </div>
                <h3 class="font-bold text-gray-900 text-lg">{{ $member->name }}</h3>
                <p class="text-orange-600 text-sm font-semibold mt-1">{{ $member->role }}</p>

                @if($member->website_url)
                <div class="mt-4 pt-4 border-t border-gray-100 mt-auto">
                    <a href="{{ $member->website_url }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 bg-orange-50 hover:bg-orange-500 text-orange-600 hover:text-white border border-orange-200 hover:border-orange-500 font-semibold text-xs px-4 py-2 rounded-lg transition-all duration-200">
                        <i class="fas fa-globe text-xs"></i> Visit Website
                    </a>
                </div>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 py-12">No founder members found.</p>
        @endif
    </div>
</section>
@endsection
