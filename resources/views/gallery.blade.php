@extends('layouts.app')
@section('title', 'Gallery — Neem Karoli Baba Foundation Worldwide')

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

        {{-- Header --}}
        <div class="text-center mb-10">
            <span class="section-tag">Memories & Milestones</span>
            <h2 class="text-3xl font-black text-gray-900 mt-1">Photo & Video <span class="text-orange-600">Gallery</span></h2>
            <p class="text-gray-500 text-sm mt-2">Click any item to view in full detail</p>
        </div>

        {{-- Grid --}}
        <div id="items-container" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-5">
            @forelse($items as $item)
                @include('partials.gallery-cards', ['items' => collect([$item])])
            @empty
            <div class="col-span-4 text-center py-24">
                <div class="w-24 h-24 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-images text-purple-300 text-4xl"></i>
                </div>
                <p class="text-gray-400 text-lg font-medium">Gallery coming soon!</p>
                <p class="text-gray-300 text-sm mt-1">Check back later for photos and videos.</p>
            </div>
            @endforelse
        </div>

        {{-- Load More --}}
        @if($hasMore)
        <div class="text-center mt-12" id="load-more-wrapper">
            <div id="load-more-spinner" class="load-more-spinner mx-auto mb-4"></div>
            <button id="load-more-btn" data-page="2" data-url="{{ route('gallery') }}"
                    class="inline-flex items-center gap-2 bg-purple-900 hover:bg-purple-800 text-white font-bold py-3 px-8 rounded-xl transition shadow-lg">
                <i class="fas fa-plus-circle"></i> Load More
            </button>
        </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════════════
     GALLERY MODAL — shows ALL admin-inputted details
══════════════════════════════════════════════════════ --}}
<div id="galleryModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center p-4"
     style="background: rgba(0,0,0,0.92); backdrop-filter: blur(6px);">

    {{-- Close button --}}
    <button onclick="closeGalleryModal()"
            class="absolute top-4 right-5 text-white/70 hover:text-white transition z-10 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center">
        <i class="fas fa-times text-lg"></i>
    </button>

    {{-- Modal box --}}
    <div id="modalBox"
         class="relative bg-gray-950 rounded-3xl overflow-hidden shadow-2xl w-full max-w-4xl max-h-[90vh] flex flex-col"
         onclick="event.stopPropagation()">

        {{-- Media area --}}
        <div id="modalMedia" class="relative bg-black flex-shrink-0">
            {{-- filled by JS --}}
        </div>

        {{-- Details area --}}
        <div id="modalDetails" class="p-6 flex-shrink-0">
            {{-- filled by JS --}}
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// ── Load More ──────────────────────────────────────────────────
const btn       = document.getElementById('load-more-btn');
const spinner   = document.getElementById('load-more-spinner');
const container = document.getElementById('items-container');

if (btn) {
    btn.addEventListener('click', loadMore);
    const obs = new IntersectionObserver(entries => {
        if (entries[0].isIntersecting) loadMore();
    }, { rootMargin: '200px' });
    obs.observe(btn);
}

async function loadMore() {
    if (!btn || btn.disabled) return;
    const page = parseInt(btn.dataset.page);
    btn.disabled = true;
    btn.style.opacity = '0.5';
    if (spinner) spinner.style.display = 'block';
    try {
        const res  = await fetch(`${btn.dataset.url}?page=${page}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await res.json();
        if (data.html) {
            const tmp = document.createElement('div');
            tmp.innerHTML = data.html;
            Array.from(tmp.children).forEach(c => container.appendChild(c));
        }
        if (data.has_more) {
            btn.dataset.page = data.next_page;
            btn.disabled = false;
            btn.style.opacity = '1';
        } else {
            document.getElementById('load-more-wrapper').innerHTML =
                '<p class="text-gray-400 text-sm py-2">✓ All items loaded</p>';
        }
    } catch(e) {
        btn.disabled = false;
        btn.style.opacity = '1';
    }
    if (spinner) spinner.style.display = 'none';
}

// ── Gallery Modal ──────────────────────────────────────────────
function openGalleryModal(el) {
    const raw  = el.getAttribute('data-item');
    const data = JSON.parse(raw);
    const modal = document.getElementById('galleryModal');
    const mediaEl   = document.getElementById('modalMedia');
    const detailsEl = document.getElementById('modalDetails');

    // ── Build media section ──
    let mediaHTML = '';

    if (data.type === 'image' || (data.type === 'both' && data.image_url)) {
        // Show full image
        mediaHTML += `
            <img src="${data.image_url}"
                 alt="${data.headline || 'Gallery Image'}"
                 class="w-full max-h-[55vh] object-contain bg-black">
        `;
    }

    if ((data.type === 'video' || data.type === 'both') && data.yt_id) {
        // YouTube embed
        mediaHTML += `
            <div style="position:relative; padding-bottom:${data.type === 'both' ? '40%' : '56.25%'}; background:#000;">
                <iframe
                    src="https://www.youtube.com/embed/${data.yt_id}?autoplay=0&rel=0&modestbranding=1"
                    style="position:absolute;top:0;left:0;width:100%;height:100%;"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen>
                </iframe>
            </div>
        `;
    }

    if (!mediaHTML) {
        mediaHTML = `
            <div class="w-full h-40 bg-gray-800 flex items-center justify-center">
                <i class="fas fa-image text-gray-600 text-5xl"></i>
            </div>
        `;
    }

    mediaEl.innerHTML = mediaHTML;

    // ── Build details section ──
    let detailsHTML = '';

    // Headline
    if (data.headline) {
        detailsHTML += `
            <h3 class="text-white font-bold text-xl mb-3 leading-tight">${data.headline}</h3>
        `;
    }

    // Type badge + YouTube link row
    let metaRow = '<div class="flex flex-wrap items-center gap-3">';

    // Type badge
    const typeConfig = {
        'image': { label: 'Photo', icon: 'fa-image',       bg: 'bg-blue-600/30 text-blue-300 border-blue-600/40' },
        'video': { label: 'Video', icon: 'fab fa-youtube', bg: 'bg-red-600/30 text-red-300 border-red-600/40' },
        'both':  { label: 'Photo + Video', icon: 'fa-photo-film', bg: 'bg-purple-600/30 text-purple-300 border-purple-600/40' },
    };
    const tc = typeConfig[data.type] || typeConfig['image'];
    metaRow += `
        <span class="inline-flex items-center gap-1.5 border ${tc.bg} text-xs font-semibold px-3 py-1 rounded-full">
            <i class="${tc.icon} text-xs"></i> ${tc.label}
        </span>
    `;

    // YouTube external link
    if (data.youtube_url) {
        metaRow += `
            <a href="${data.youtube_url}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1.5 bg-red-600/20 border border-red-600/40 text-red-300 text-xs font-semibold px-3 py-1 rounded-full hover:bg-red-600/40 transition">
                <i class="fab fa-youtube text-xs"></i> Watch on YouTube
            </a>
        `;
    }

    // View full image link
    if (data.image_url) {
        metaRow += `
            <a href="${data.image_url}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1.5 bg-white/10 border border-white/20 text-gray-300 text-xs font-semibold px-3 py-1 rounded-full hover:bg-white/20 transition">
                <i class="fas fa-arrow-up-right-from-square text-xs"></i> Open Full Image
            </a>
        `;
    }

    metaRow += '</div>';
    detailsHTML += metaRow;

    if (!data.headline && !data.youtube_url && !data.image_url) {
        detailsHTML = `<p class="text-gray-500 text-sm">No additional details.</p>`;
    }

    detailsEl.innerHTML = detailsHTML;

    // Show modal
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeGalleryModal() {
    const modal   = document.getElementById('galleryModal');
    const mediaEl = document.getElementById('modalMedia');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    document.body.style.overflow = '';
    // Stop iframe video playback
    mediaEl.innerHTML = '';
}

// Close on backdrop click
document.getElementById('galleryModal').addEventListener('click', function(e) {
    if (e.target === this) closeGalleryModal();
});

// Close on Escape key
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeGalleryModal(); });
</script>
@endpush
