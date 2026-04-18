@extends('layouts.app')
@section('title', 'Media Coverage — '.$siteName)
@section('meta_desc', 'Read media coverage and news articles featuring '.$siteName.' — press coverage of our charitable initiatives, events, and humanitarian work across India.')
@section('meta_keywords', 'NKB Foundation media coverage, '.$siteName.' news, NGO press coverage India, NKB Foundation in media, charity news India, foundation press')
@section('canonical', route('media-coverage'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Media Coverage — {{ $siteName }}",
  "url": "{{ route('media-coverage') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "Media Coverage", "item": "{{ route('media-coverage') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
{{-- Banner --}}
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag" style="color:#f97316">In The News</span>
        <h1 class="text-4xl md:text-5xl font-black mt-1 mb-2">Media Coverage</h1>
        <p class="text-purple-200 text-sm">Our work covered by news, TV channels and online media</p>
        <nav class="flex mt-3 text-sm items-center gap-1">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <span class="text-gray-300">Media Coverage</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header + Filters --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div class="text-center md:text-left">
                <span class="section-tag">Press & Media</span>
                <h2 class="text-3xl font-black text-gray-900 mt-1">Featured In <span class="text-orange-600">Media</span></h2>
            </div>
            <div class="flex flex-wrap items-center gap-2 justify-center md:justify-end">
                {{-- Year filter (always visible, dropdown) --}}
                <select onchange="location.href=this.value" class="text-xs font-bold border-2 border-purple-200 rounded-xl px-4 py-2 bg-white focus:outline-none focus:border-purple-600 text-gray-700">
                    @for($y = $currentYear + 2; $y >= $currentYear - 10; $y--)
                    <option value="{{ route('media-coverage') }}?{{ http_build_query(array_filter(['year' => $y, 'category' => $category ?: null])) }}"
                        {{ $year == $y ? 'selected' : '' }}>
                        {{ $y }}{{ $y == $currentYear ? ' (Current)' : '' }}
                    </option>
                    @endfor
                </select>
                {{-- Category filter --}}
                @foreach([''=>'All','news'=>'News','tv'=>'TV / Video','online'=>'Online','magazine'=>'Magazine'] as $key => $label)
                <a href="{{ route('media-coverage') }}?{{ http_build_query(array_filter(['year' => $year, 'category' => $key ?: null])) }}"
                   class="text-xs font-bold px-4 py-2 rounded-full transition {{ $category == $key ? 'bg-purple-900 text-white' : 'bg-white text-gray-600 hover:bg-purple-100 border border-gray-200' }}">
                    {{ $label }}
                </a>
                @endforeach
            </div>
        </div>

        {{-- Cards --}}
        <div class="flex flex-col gap-4">
            @forelse($coverages as $coverage)
                @include('partials.media-coverage-cards', ['coverages' => collect([$coverage]), 'horizontal' => true])
            @empty
            <div class="text-center py-24">
                <div class="w-24 h-24 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-newspaper text-purple-300 text-4xl"></i>
                </div>
                <p class="text-gray-500 text-lg font-semibold">No media coverage found for {{ $year }}</p>
                <p class="text-gray-400 text-sm mt-1">Try selecting a different year from the dropdown above.</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-10">{{ $coverages->links() }}</div>

    </div>
</section>

{{-- Video Modal --}}
<div id="mediaModal" class="fixed inset-0 z-[9999] hidden items-center justify-center p-4"
     style="background:rgba(0,0,0,0.92);backdrop-filter:blur(6px);">
    <button onclick="closeMediaModal()"
            class="absolute top-4 right-5 text-white/70 hover:text-white z-10 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center">
        <i class="fas fa-times text-lg"></i>
    </button>
    <div class="bg-gray-950 rounded-3xl overflow-hidden shadow-2xl w-full max-w-3xl" onclick="event.stopPropagation()">
        <div id="mediaModalContent" class="relative bg-black" style="padding-bottom:56.25%">
            <iframe id="mediaModalFrame" src="" class="absolute inset-0 w-full h-full"
                    frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
        <div class="p-5">
            <p id="mediaModalTitle" class="text-white font-bold text-base"></p>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Video Modal ────────────────────────────────────────────────
function openMediaModal(ytId, title) {
    document.getElementById('mediaModalFrame').src = `https://www.youtube.com/embed/${ytId}?autoplay=1&rel=0`;
    document.getElementById('mediaModalTitle').textContent = title || '';
    const m = document.getElementById('mediaModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeMediaModal() {
    document.getElementById('mediaModalFrame').src = '';
    const m = document.getElementById('mediaModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    document.body.style.overflow = '';
}
document.getElementById('mediaModal').addEventListener('click', function(e) {
    if (e.target === this) closeMediaModal();
});
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeMediaModal(); });
</script>
@endpush
