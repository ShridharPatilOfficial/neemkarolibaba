@extends('layouts.app')
@section('title', 'Events — Neem Karoli Baba Foundation Worldwide')
@section('meta_desc', 'Stay updated with upcoming and past events by Neem Karoli Baba Foundation Worldwide — spiritual gatherings, charity drives, and community programs across India.')
@section('meta_keywords', 'NKB Foundation events, Neem Karoli Baba events, NGO events India, spiritual events, charity events, bhajan sandhya, NKB Foundation programs')
@section('canonical', route('events'))
@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Events — Neem Karoli Baba Foundation Worldwide",
  "url": "{{ route('events') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "Events", "item": "{{ route('events') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Events</h1>
        <p class="text-purple-200">Neem Karoli Baba Foundation Worldwide</p>
        <nav class="flex mt-3 text-sm">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">Events</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto">
        <div id="items-container" class="space-y-0">
            @forelse($items as $item)
                @include('partials.content-cards', ['items' => collect([$item])])
                <hr class="border-gray-100 my-4">
            @empty
                <div class="text-center py-20">
                    <i class="fas fa-calendar-alt text-gray-200 text-7xl mb-4"></i>
                    <p class="text-gray-400 text-lg">No events found. Check back soon!</p>
                </div>
            @endforelse
        </div>

        @if($hasMore)
        <div class="text-center mt-10">
            <div id="load-more-spinner" class="load-more-spinner mx-auto mb-4"></div>
            <button id="load-more-btn" data-page="2" data-url="{{ route('events') }}"
                    class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-bold py-3 px-8 rounded-full transition">
                <i class="fas fa-plus-circle"></i> Load More
            </button>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    @include('partials.load-more-script')
</script>
@endpush
