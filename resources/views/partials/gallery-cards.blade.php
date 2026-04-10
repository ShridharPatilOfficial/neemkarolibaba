@foreach($items as $item)
@php
    $imgSrc = $item->image_url
        ? (str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url))
        : null;

    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $item->youtube_url ?? '', $ytm);
    $ytId = $ytm[1] ?? null;

    // Thumbnail for video-only items
    $thumbSrc = $imgSrc ?: ($ytId ? "https://img.youtube.com/vi/{$ytId}/hqdefault.jpg" : null);

    // JSON payload for modal (all admin fields)
    $modalData = json_encode([
        'type'        => $item->type,
        'headline'    => $item->headline ?? '',
        'image_url'   => $imgSrc,
        'youtube_url' => $item->youtube_url ?? '',
        'yt_id'       => $ytId,
    ]);
@endphp

<div class="gallery-card group relative rounded-2xl overflow-hidden shadow-md cursor-pointer bg-gray-100"
     onclick="openGalleryModal(this)"
     data-item="{{ htmlspecialchars($modalData, ENT_QUOTES) }}">

    {{-- Thumbnail --}}
    @if($thumbSrc)
    <div class="overflow-hidden">
        <img src="{{ $thumbSrc }}" alt="{{ $item->headline ?? 'Gallery' }}"
             class="w-full h-56 object-cover group-hover:scale-105 transition-transform duration-500 pointer-events-none">
    </div>
    @else
    <div class="w-full h-56 bg-gradient-to-br from-purple-100 to-orange-50 flex items-center justify-center">
        <i class="fas fa-image text-purple-300 text-5xl"></i>
    </div>
    @endif

    {{-- Hover overlay --}}
    <div class="absolute inset-0 bg-black/0 group-hover:bg-black/45 transition-all duration-300 flex items-center justify-center">
        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform scale-75 group-hover:scale-100">
            @if($item->type === 'video' || ($item->type === 'both' && $ytId))
            <div class="w-14 h-14 rounded-full bg-red-600 flex items-center justify-center shadow-xl">
                <i class="fas fa-play text-white text-xl ml-1"></i>
            </div>
            @else
            <div class="w-14 h-14 rounded-full bg-white/90 flex items-center justify-center shadow-xl">
                <i class="fas fa-expand text-gray-800 text-lg"></i>
            </div>
            @endif
        </div>
    </div>

    {{-- Type badge --}}
    <div class="absolute top-2 right-2">
        @if($item->type === 'video')
        <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
            <i class="fab fa-youtube text-xs"></i> Video
        </span>
        @elseif($item->type === 'both')
        <span class="bg-purple-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1">
            <i class="fas fa-photo-film text-xs"></i> Media
        </span>
        @endif
    </div>

    {{-- Headline bar at bottom --}}
    @if($item->headline)
    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent px-4 py-3">
        <p class="text-white text-sm font-semibold leading-tight">{{ $item->headline }}</p>
    </div>
    @endif
</div>
@endforeach
