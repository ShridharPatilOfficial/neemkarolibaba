@extends('layouts.app')
@section('title', 'Founder Members — Neem Karoli Baba Foundation Worldwide')
@section('meta_desc', 'Meet the founder members and trustees of Neem Karoli Baba Foundation Worldwide — dedicated individuals committed to Maharaj-ji\'s vision of selfless service and love for all.')
@section('meta_keywords', 'NKB Foundation founders, Neem Karoli Baba Foundation trustees, NGO founders India, NKB Foundation team, foundation members, charity trustees India')
@section('canonical', route('about.founders'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Founder Members — Neem Karoli Baba Foundation Worldwide",
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
        <p class="text-purple-200">Neem Karoli Baba Foundation Worldwide</p>
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
            <div class="card-hover bg-white border border-gray-100 rounded-2xl p-6 text-center shadow-sm">
                <div class="w-32 h-32 mx-auto mb-4 rounded-xl overflow-hidden border-2 border-gray-200 bg-gray-100">
                    @if($member->photo_url)
                        <img src="{{ str_starts_with($member->photo_url, 'http') ? $member->photo_url : asset('storage/' . $member->photo_url) }}"
                             alt="{{ $member->name }}" class="w-full h-full object-cover grayscale">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-purple-100">
                            <i class="fas fa-user text-purple-400 text-4xl"></i>
                        </div>
                    @endif
                </div>
                <h3 class="font-bold text-gray-900 text-lg">{{ $member->name }}</h3>
                <p class="text-gray-500 text-sm mt-1">{{ $member->role }}</p>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 py-12">No founder members found.</p>
        @endif
    </div>
</section>
@endsection
