@extends('layouts.app')
@section('title', 'Photo Gallery — Neem Karoli Baba Foundation Worldwide')
@section('meta_desc', 'Browse the photo gallery of Neem Karoli Baba Foundation Worldwide — images from seva programs, events, charity work, spiritual gatherings, and community outreach across India.')
@section('meta_keywords', 'NKB Foundation gallery, Neem Karoli Baba photos, NGO India photos, seva gallery, charity event photos, NKB Foundation images, foundation gallery India')
@section('canonical', route('gallery'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ImageGallery",
  "name": "Photo Gallery — Neem Karoli Baba Foundation Worldwide",
  "url": "{{ route('gallery') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "Gallery", "item": "{{ route('gallery') }}" }
    ]
  }
}
</script>
@endpush

@section('content')

{{-- Page Banner --}}
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag" style="color:#f97316">Our Media</span>
        <h1 class="text-4xl md:text-5xl font-black mt-1 mb-2">Gallery</h1>
        <p class="text-purple-200 text-sm">Moments of service, compassion, and community</p>
        <nav class="flex mt-3 text-sm items-center gap-1">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <span class="text-gray-300">Gallery</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <div class="text-center mb-10">
            <span class="section-tag">Memories & Milestones</span>
            <h2 class="text-3xl font-black text-gray-900 mt-1">Photo & Video <span class="text-orange-600">Gallery</span></h2>
            <p class="text-gray-500 text-sm mt-2">Click any item to view — use arrows to browse all</p>
        </div>

        {{-- Grid --}}
        <div id="items-container" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($items as $index => $item)
                @include('partials.gallery-cards', ['items' => collect([$item]), 'startIndex' => $index])
            @empty
            <div class="col-span-4 text-center py-24">
                <div class="w-24 h-24 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-images text-purple-300 text-4xl"></i>
                </div>
                <p class="text-gray-400 text-lg font-medium">Gallery coming soon!</p>
            </div>
            @endforelse
        </div>

        {{-- Load More --}}
        @if($hasMore)
        <div class="text-center mt-12" id="load-more-wrapper">
            <button id="load-more-btn" data-page="2" data-url="{{ route('gallery') }}"
                    class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg">
                <i class="fas fa-plus-circle"></i> Load More
            </button>
        </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     CAROUSEL LIGHTBOX MODAL
══════════════════════════════════════════════════════ --}}
<div id="galleryModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center"
     style="background:rgba(0,0,0,0.95);backdrop-filter:blur(8px);">

    {{-- Close --}}
    <button onclick="closeGalleryModal()"
            class="absolute top-4 right-4 z-20 w-11 h-11 rounded-full bg-white/10 hover:bg-white/25 text-white flex items-center justify-center transition text-lg">
        <i class="fas fa-times"></i>
    </button>

    {{-- Counter --}}
    <div id="modalCounter"
         class="absolute top-4 left-1/2 -translate-x-1/2 z-20 bg-black/50 text-white text-xs font-bold px-4 py-1.5 rounded-full backdrop-blur-sm">
        1 / 1
    </div>

    {{-- Prev arrow --}}
    <button id="modalPrev" onclick="carouselNav(-1)"
            class="absolute left-3 md:left-6 z-20 w-12 h-12 rounded-full bg-white/10 hover:bg-orange-600 text-white flex items-center justify-center transition text-lg shadow-xl">
        <i class="fas fa-chevron-left"></i>
    </button>

    {{-- Next arrow --}}
    <button id="modalNext" onclick="carouselNav(1)"
            class="absolute right-3 md:right-6 z-20 w-12 h-12 rounded-full bg-white/10 hover:bg-orange-600 text-white flex items-center justify-center transition text-lg shadow-xl">
        <i class="fas fa-chevron-right"></i>
    </button>

    {{-- Modal card --}}
    <div id="modalBox"
         class="relative bg-gray-950 rounded-2xl overflow-hidden shadow-2xl w-full max-w-4xl mx-14 md:mx-20 flex flex-col"
         style="max-height:90vh;"
         onclick="event.stopPropagation()">

        {{-- Media — fills width --}}
        <div id="modalMedia" class="bg-black w-full flex-shrink-0" style="overflow:hidden;">
        </div>

        {{-- Thumbnail strip inside modal --}}
        <div id="modalThumbs"
             class="flex items-center gap-2 px-4 py-2.5 bg-black overflow-x-auto flex-shrink-0"
             style="scrollbar-width:thin;scrollbar-color:#4b5563 transparent;">
        </div>

        {{-- Details --}}
        <div id="modalDetails" class="p-4 flex-shrink-0 bg-gray-950">
        </div>
    </div>
</div>

@endsection

@php
$galleryJson = $items->map(function($i) {
    preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $i->youtube_url ?? '', $m);
    return [
        'id'          => $i->id,
        'headline'    => $i->headline,
        'type'        => $i->type,
        'image_url'   => $i->image_url && !str_starts_with($i->image_url,'http') ? asset('storage/'.$i->image_url) : $i->image_url,
        'youtube_url' => $i->youtube_url,
        'yt_id'       => $m[1] ?? null,
    ];
});
@endphp

@push('scripts')
<script>
// ── All gallery items (populated from PHP) ─────────────────────
const galleryItems = {!! json_encode($galleryJson) !!};

let allItems    = [...galleryItems]; // grows as more pages load
let currentIdx  = 0;

// ── Load More ──────────────────────────────────────────────────
const loadBtn   = document.getElementById('load-more-btn');
const container = document.getElementById('items-container');

if (loadBtn) {
    const obs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) loadMore();
    }, { rootMargin: '200px' });
    obs.observe(loadBtn);
    loadBtn.addEventListener('click', loadMore);
}

async function loadMore() {
    if (!loadBtn || loadBtn.disabled) return;
    const page = parseInt(loadBtn.dataset.page);
    loadBtn.disabled = true;
    loadBtn.style.opacity = '0.5';
    try {
        const res  = await fetch(`${loadBtn.dataset.url}?page=${page}`, { headers: {'X-Requested-With':'XMLHttpRequest'} });
        const data = await res.json();
        if (data.html) {
            const tmp = document.createElement('div');
            tmp.innerHTML = data.html;
            // Assign correct indices before appending
            Array.from(tmp.querySelectorAll('[data-index]')).forEach((el, i) => {
                el.dataset.index = allItems.length + i;
            });
            Array.from(tmp.children).forEach(c => container.appendChild(c));
        }
        if (data.items) allItems = allItems.concat(data.items);
        if (data.has_more) {
            loadBtn.dataset.page = data.next_page;
            loadBtn.disabled = false;
            loadBtn.style.opacity = '1';
        } else {
            document.getElementById('load-more-wrapper').innerHTML =
                '<p class="text-gray-400 text-sm py-2">✓ All items loaded</p>';
        }
    } catch(e) {
        loadBtn.disabled = false;
        loadBtn.style.opacity = '1';
    }
}

// ── Open modal at index ────────────────────────────────────────
function openGalleryModal(el) {
    const idx = parseInt(el.dataset.index ?? 0);
    currentIdx = idx;
    renderModal();
    const m = document.getElementById('galleryModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    buildThumbs();
}

function closeGalleryModal() {
    document.getElementById('galleryModal').classList.add('hidden');
    document.getElementById('galleryModal').classList.remove('flex');
    document.getElementById('modalMedia').innerHTML = '';
    document.body.style.overflow = '';
}

function carouselNav(dir) {
    currentIdx = (currentIdx + dir + allItems.length) % allItems.length;
    renderModal();
    highlightThumb();
}

function renderModal() {
    const data     = allItems[currentIdx];
    const mediaEl  = document.getElementById('modalMedia');
    const detailEl = document.getElementById('modalDetails');
    const counter  = document.getElementById('modalCounter');

    // counter
    counter.textContent = `${currentIdx + 1} / ${allItems.length}`;

    // media
    let mediaHTML = '';
    if ((data.type === 'image' || data.type === 'both') && data.image_url) {
        mediaHTML += `<div style="width:100%;height:52vh;background:#000;display:flex;align-items:center;justify-content:center;overflow:hidden;">
            <img src="${data.image_url}" alt="${data.headline || ''}"
                 style="max-width:100%;max-height:100%;width:auto;height:auto;display:block;object-fit:contain;">
        </div>`;
    }
    if ((data.type === 'video' || data.type === 'both') && data.yt_id) {
        const ptb = data.type === 'both' ? '35%' : '52vh';
        const wrapStyle = data.type === 'both'
            ? `position:relative;padding-bottom:35%;width:100%;background:#000;`
            : `position:relative;width:100%;height:52vh;background:#000;`;
        mediaHTML += `<div style="${wrapStyle}">
            <iframe src="https://www.youtube.com/embed/${data.yt_id}?autoplay=0&rel=0&modestbranding=1"
                    style="position:absolute;top:0;left:0;width:100%;height:100%;"
                    frameborder="0" allow="accelerometer;autoplay;clipboard-write;encrypted-media;gyroscope;picture-in-picture" allowfullscreen></iframe>
        </div>`;
    }
    if (!mediaHTML) {
        mediaHTML = `<div style="width:100%;height:52vh;background:#1f2937;display:flex;align-items:center;justify-content:center;">
            <i class="fas fa-image" style="color:#4b5563;font-size:3rem;"></i></div>`;
    }
    mediaEl.innerHTML = mediaHTML;

    // details
    const typeMap = {
        image: { label:'Photo',        icon:'fa-image',       cls:'bg-blue-600/30 text-blue-300 border-blue-600/40' },
        video: { label:'Video',         icon:'fab fa-youtube', cls:'bg-red-600/30 text-red-300 border-red-600/40' },
        both:  { label:'Photo + Video', icon:'fa-photo-film',  cls:'bg-purple-600/30 text-purple-300 border-purple-600/40' },
    };
    const tc = typeMap[data.type] || typeMap.image;
    let det = '';
    if (data.headline) det += `<h3 class="text-white font-bold text-base mb-2 leading-tight">${data.headline}</h3>`;
    det += `<div class="flex flex-wrap gap-2">
        <span class="inline-flex items-center gap-1 border ${tc.cls} text-xs font-semibold px-3 py-1 rounded-full">
            <i class="${tc.icon} text-xs"></i> ${tc.label}</span>`;
    if (data.youtube_url)
        det += `<a href="${data.youtube_url}" target="_blank"
               class="inline-flex items-center gap-1 bg-red-600/20 border border-red-600/40 text-red-300 text-xs font-semibold px-3 py-1 rounded-full hover:bg-red-600/40 transition">
               <i class="fab fa-youtube text-xs"></i> Watch on YouTube</a>`;
    if (data.image_url)
        det += `<a href="${data.image_url}" target="_blank"
               class="inline-flex items-center gap-1 bg-white/10 border border-white/20 text-gray-300 text-xs font-semibold px-3 py-1 rounded-full hover:bg-white/20 transition">
               <i class="fas fa-arrow-up-right-from-square text-xs"></i> Full Image</a>`;
    det += '</div>';
    detailEl.innerHTML = det;
}

// ── Thumbnail strip ────────────────────────────────────────────
function buildThumbs() {
    const strip = document.getElementById('modalThumbs');
    strip.innerHTML = '';
    allItems.forEach((item, i) => {
        const thumb = item.image_url ||
            (item.yt_id ? `https://img.youtube.com/vi/${item.yt_id}/mqdefault.jpg` : '');
        const btn = document.createElement('button');
        btn.className = `flex-shrink-0 w-14 h-10 rounded-lg overflow-hidden border-2 transition
            ${i === currentIdx ? 'border-orange-500 scale-110' : 'border-transparent opacity-60 hover:opacity-100'}`;
        btn.onclick = () => { currentIdx = i; renderModal(); highlightThumb(); };
        if (thumb) {
            btn.innerHTML = `<img src="${thumb}" class="w-full h-full object-cover">`;
        } else {
            btn.innerHTML = `<div class="w-full h-full bg-gray-700 flex items-center justify-center">
                <i class="fas fa-image text-gray-500 text-xs"></i></div>`;
        }
        btn.dataset.thumbIdx = i;
        strip.appendChild(btn);
    });
}

function highlightThumb() {
    const strip = document.getElementById('modalThumbs');
    document.querySelectorAll('#modalThumbs button').forEach((btn, i) => {
        if (i === currentIdx) {
            btn.className = btn.className.replace('border-transparent opacity-60', '');
            btn.classList.add('border-orange-500', 'scale-110');
            // scroll thumb strip (not page) to keep active thumb visible
            const btnLeft = btn.offsetLeft;
            const btnW    = btn.offsetWidth;
            const stripW  = strip.offsetWidth;
            strip.scrollTo({ left: btnLeft - stripW / 2 + btnW / 2, behavior: 'smooth' });
        } else {
            btn.classList.remove('border-orange-500', 'scale-110');
            btn.classList.add('border-transparent', 'opacity-60');
        }
    });
}

// Backdrop + keyboard
document.getElementById('galleryModal').addEventListener('click', function(e) {
    if (e.target === this) closeGalleryModal();
});
document.addEventListener('keydown', e => {
    const m = document.getElementById('galleryModal');
    if (m.classList.contains('hidden')) return;
    if (e.key === 'Escape')      closeGalleryModal();
    if (e.key === 'ArrowRight')  carouselNav(1);
    if (e.key === 'ArrowLeft')   carouselNav(-1);
});

// Touch swipe
let touchStartX = 0;
document.getElementById('modalBox')?.addEventListener('touchstart', e => { touchStartX = e.touches[0].clientX; });
document.getElementById('modalBox')?.addEventListener('touchend',   e => {
    const diff = touchStartX - e.changedTouches[0].clientX;
    if (Math.abs(diff) > 50) carouselNav(diff > 0 ? 1 : -1);
});
</script>
@endpush
