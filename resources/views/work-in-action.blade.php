@extends('layouts.app')
@section('title', 'Work in Action — '.$siteName)
@section('meta_desc', 'Watch '.$siteName.' in action — real videos of our seva programmes, health camps, education drives, and community outreach across India.')
@section('canonical', route('work-in-action'))

@section('content')

{{-- Banner --}}
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag" style="color:#f97316">Watch &amp; Learn</span>
        <h1 class="text-4xl md:text-5xl font-black mt-1 mb-2">Work in Action</h1>
        <p class="text-purple-200 text-sm">Real moments, real lives changed — watch our programmes and drives on the ground.</p>
        <nav class="flex mt-3 text-sm items-center gap-1">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <span class="text-gray-300">Work in Action</span>
        </nav>
    </div>
</div>

{{-- Videos Grid --}}
<section class="py-16 px-4" style="background:linear-gradient(135deg,#0C0920 0%,#150D35 100%);">
    <div class="max-w-7xl mx-auto">

        @if($videos->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-7">
            @foreach($videos as $vid)
            @php $ytId = $vid->youtube_id; @endphp
            <div class="group relative bg-gray-900 rounded-2xl overflow-hidden shadow-lg border border-white/8
                        hover:border-orange-500/45 hover:-translate-y-2 hover:shadow-orange-900/35 hover:shadow-2xl
                        transition-all duration-300 flex flex-col">

                {{-- Thumbnail — click here to open video --}}
                <div class="relative overflow-hidden flex-shrink-0 cursor-pointer" style="height:220px;"
                     onclick="openWorkVideo('{{ $ytId }}','{{ addslashes($vid->title) }}')">
                    <img src="{{ $ytId ? 'https://img.youtube.com/vi/'.$ytId.'/hqdefault.jpg' : 'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=600&q=80' }}"
                         alt="{{ $vid->title }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    {{-- Play button --}}
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-16 h-16 rounded-full bg-red-600 group-hover:bg-red-500 group-hover:scale-110
                                    flex items-center justify-center shadow-2xl transition-all duration-300
                                    ring-4 ring-red-600/30 group-hover:ring-red-500/50">
                            <i class="fas fa-play text-white text-lg ml-1"></i>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3">
                        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-lg flex items-center gap-1">
                            <i class="fab fa-youtube text-xs"></i> YouTube
                        </span>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="text-white font-bold text-base leading-snug mb-2 group-hover:text-orange-300 transition-colors">{{ $vid->title }}</h3>
                    @if($vid->description)
                    <div class="text-gray-400 text-sm rich-text-dark card-desc-truncated" id="wiadesc-{{ $vid->id }}">
                        {!! $vid->description !!}
                    </div>
                    <button class="card-read-more" onclick="event.stopPropagation(); toggleDesc('wiadesc-{{ $vid->id }}', this)">
                        Read More <i class="fas fa-chevron-down text-[10px]"></i>
                    </button>
                    @endif
                    <div class="mt-4 flex items-center gap-1.5 text-orange-400 text-xs font-semibold cursor-pointer"
                         onclick="openWorkVideo('{{ $ytId }}','{{ addslashes($vid->title) }}')">
                        <i class="fas fa-play-circle text-sm"></i> Watch Now
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Per-page + Pagination --}}
        <div class="mt-10 flex flex-wrap items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <label class="text-purple-400 text-sm font-semibold">Show:</label>
                <select onchange="location.href=this.value" class="text-sm font-bold border-2 border-purple-700 rounded-xl px-4 py-2 bg-gray-900 text-purple-200 focus:outline-none focus:border-purple-500">
                    @foreach([25, 50, 100] as $size)
                    <option value="{{ route('work-in-action') }}?per_page={{ $size }}"
                        {{ $perPage == $size ? 'selected' : '' }}>
                        {{ $size }} per page
                    </option>
                    @endforeach
                </select>
            </div>
            <div>{{ $videos->links() }}</div>
        </div>

        @else
        <div class="text-center py-24">
            <div class="w-24 h-24 rounded-full bg-white/8 border border-white/15 flex items-center justify-center mx-auto mb-5">
                <i class="fab fa-youtube text-red-400 text-4xl"></i>
            </div>
            <p class="text-purple-300 text-lg font-semibold mb-2">Videos coming soon!</p>
            <p class="text-purple-400 text-sm">Our team is uploading programme videos. Check back shortly.</p>
        </div>
        @endif

    </div>
</section>

{{-- Video Modal --}}
<div id="workVideoModal"
     class="fixed inset-0 z-[99999] hidden items-center justify-center"
     style="background:rgba(0,0,0,.95);backdrop-filter:blur(8px);"
     onclick="if(event.target===this)closeWorkVideo()">
    <button onclick="closeWorkVideo()"
            class="absolute top-4 right-4 w-11 h-11 rounded-full bg-white/10 hover:bg-orange-500 text-white flex items-center justify-center transition text-lg z-10">
        <i class="fas fa-times"></i>
    </button>
    <div class="w-full max-w-4xl mx-4" onclick="event.stopPropagation()">
        <p id="workVideoTitle" class="text-white font-bold text-base mb-3 px-1"></p>
        <div class="relative rounded-2xl overflow-hidden bg-black" style="padding-top:56.25%;">
            <iframe id="workVideoFrame" src="" allow="autoplay;encrypted-media;fullscreen"
                    class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen></iframe>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function openWorkVideo(ytId, title) {
    if (!ytId) return;
    document.getElementById('workVideoFrame').src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1&rel=0';
    document.getElementById('workVideoTitle').textContent = title || '';
    const m = document.getElementById('workVideoModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeWorkVideo() {
    document.getElementById('workVideoFrame').src = '';
    const m = document.getElementById('workVideoModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeWorkVideo(); });
// Move modal to body root so no ancestor stacking context traps it
document.body.appendChild(document.getElementById('workVideoModal'));
</script>
@endpush
