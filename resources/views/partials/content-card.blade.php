@php
    $imgSrc = $item->image_url ? (str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url)) : null;
    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $item->youtube_url ?? '', $ytm);
    $ytId = $ytm[1] ?? null;
@endphp
<div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">

    {{-- Media --}}
    @if($imgSrc && $ytId)
        <img src="{{ $imgSrc }}" alt="{{ $item->heading }}"
             class="w-full h-52 object-cover cursor-zoom-in"
             onclick="imgLb(this)" data-full="{{ $imgSrc }}" data-caption="{{ $item->heading }}">
        <div class="relative" style="padding-top:56.25%">
            <iframe src="https://www.youtube.com/embed/{{ $ytId }}" class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen></iframe>
        </div>
    @elseif($imgSrc)
        <img src="{{ $imgSrc }}" alt="{{ $item->heading }}"
             class="w-full h-52 object-cover cursor-zoom-in"
             onclick="imgLb(this)" data-full="{{ $imgSrc }}" data-caption="{{ $item->heading }}">
    @elseif($ytId)
        <div class="relative" style="padding-top:56.25%">
            <iframe src="https://www.youtube.com/embed/{{ $ytId }}" class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen></iframe>
        </div>
    @else
        <div class="w-full h-52 bg-purple-50 flex items-center justify-center">
            <i class="fas fa-image text-purple-200 text-5xl"></i>
        </div>
    @endif

    {{-- Content --}}
    <div class="p-5">
        <h2 class="text-lg font-extrabold text-gray-900 mb-2 leading-snug">{{ $item->heading }}</h2>
        <div class="text-gray-500 text-sm rich-text card-desc-truncated" id="cdesc-{{ $item->id }}">
            {!! $item->description !!}
        </div>
        <button class="card-read-more mt-2" onclick="toggleDesc('cdesc-{{ $item->id }}', this)">
            Read More <i class="fas fa-chevron-down text-[10px]"></i>
        </button>
    </div>
</div>
