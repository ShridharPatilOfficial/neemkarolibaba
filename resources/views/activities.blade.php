@extends('layouts.app')
@section('title', 'Our Activities — '.$siteName)
@section('meta_desc', 'Explore the charitable activities of '.$siteName.' — food distribution, education, healthcare, disaster relief, and spiritual service across India.')
@section('meta_keywords', 'NKB Foundation activities, NGO India activities, food distribution, free education, healthcare NGO, disaster relief India, Neem Karoli Baba charity work')
@section('canonical', route('activities'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Our Activities — {{ $siteName }}",
  "url": "{{ route('activities') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "Activities", "item": "{{ route('activities') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Activities</h1>
        <p class="text-purple-200">{{ $siteName }}</p>
        <nav class="flex mt-3 text-sm">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">Our Activities</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto">

        {{-- Year filter dropdown --}}
        <div class="flex items-center justify-center gap-3 mb-6">
            <label class="text-sm font-semibold text-gray-600">Filter by Year:</label>
            <select onchange="location.href=this.value"
                    class="text-sm font-bold border-2 border-purple-200 rounded-xl px-4 py-2 bg-white focus:outline-none focus:border-purple-600 text-gray-700 shadow-sm">
                @for($y = $currentYear + 2; $y >= $currentYear - 10; $y--)
                <option value="{{ route('activities') }}?year={{ $y }}"
                    {{ $year == $y ? 'selected' : '' }}>
                    {{ $y }}{{ $y == $currentYear ? ' (Current)' : '' }}
                </option>
                @endfor
            </select>
        </div>

        <div class="space-y-0">
            @forelse($items as $item)
                @include('partials.content-cards', ['items' => collect([$item])])
                <hr class="border-gray-100 my-4">
            @empty
                <div class="text-center py-20">
                    <i class="fas fa-hands-helping text-gray-200 text-7xl mb-4"></i>
                    <p class="text-gray-500 text-lg font-semibold">No activities found for {{ $year }}</p>
                    <p class="text-gray-400 text-sm mt-1">Try selecting a different year above.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-10">{{ $items->links() }}</div>
    </div>
</section>
@endsection
