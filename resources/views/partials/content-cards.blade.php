@foreach($items as $item)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center mb-16 last:mb-0 {{ $loop->even ? 'lg:flex-row-reverse' : '' }}">
    @if($loop->even)
    <!-- Text on left, media on right for even items -->
    <div>
        <h2 class="text-2xl md:text-3xl font-extrabold text-orange-600 mb-4">{{ $item->heading }}</h2>
        <div class="text-gray-600 rich-text card-desc-truncated" id="cdesc-{{ $item->id }}">
            {!! $item->description !!}
        </div>
        <button class="card-read-more mt-2" onclick="toggleDesc('cdesc-{{ $item->id }}', this)">
            Read More <i class="fas fa-chevron-down text-[10px]"></i>
        </button>
    </div>
    @php
        $imgSrc = $item->image_url ? (str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url)) : null;
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $item->youtube_url ?? '', $ytm);
        $ytId = $ytm[1] ?? null;
    @endphp
    <div class="rounded-xl overflow-hidden shadow-lg">
        @if($imgSrc && $ytId)
            <img src="{{ $imgSrc }}" alt="{{ $item->heading }}"
                 class="w-full h-64 object-cover mb-4 rounded-xl cursor-zoom-in"
                 onclick="imgLb(this)" data-full="{{ $imgSrc }}" data-caption="{{ $item->heading }}">
            <div class="relative" style="padding-top:56.25%">
                <iframe src="https://www.youtube.com/embed/{{ $ytId }}" class="absolute inset-0 w-full h-full rounded-xl" frameborder="0" allowfullscreen></iframe>
            </div>
        @elseif($imgSrc)
            <img src="{{ $imgSrc }}" alt="{{ $item->heading }}"
                 class="w-full h-72 object-cover rounded-xl cursor-zoom-in"
                 onclick="imgLb(this)" data-full="{{ $imgSrc }}" data-caption="{{ $item->heading }}">
        @elseif($ytId)
            <div class="relative rounded-xl overflow-hidden" style="padding-top:56.25%">
                <iframe src="https://www.youtube.com/embed/{{ $ytId }}" class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen></iframe>
            </div>
        @else
            <div class="w-full h-64 bg-purple-100 flex items-center justify-center rounded-xl">
                <i class="fas fa-image text-purple-300 text-5xl"></i>
            </div>
        @endif
    </div>
    @else
    @php
        $imgSrc = $item->image_url ? (str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url)) : null;
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $item->youtube_url ?? '', $ytm);
        $ytId = $ytm[1] ?? null;
    @endphp
    <div class="rounded-xl overflow-hidden shadow-lg">
        @if($imgSrc && $ytId)
            <img src="{{ $imgSrc }}" alt="{{ $item->heading }}"
                 class="w-full h-64 object-cover mb-4 rounded-xl cursor-zoom-in"
                 onclick="imgLb(this)" data-full="{{ $imgSrc }}" data-caption="{{ $item->heading }}">
            <div class="relative" style="padding-top:56.25%">
                <iframe src="https://www.youtube.com/embed/{{ $ytId }}" class="absolute inset-0 w-full h-full rounded-xl" frameborder="0" allowfullscreen></iframe>
            </div>
        @elseif($imgSrc)
            <img src="{{ $imgSrc }}" alt="{{ $item->heading }}"
                 class="w-full h-72 object-cover rounded-xl cursor-zoom-in"
                 onclick="imgLb(this)" data-full="{{ $imgSrc }}" data-caption="{{ $item->heading }}">
        @elseif($ytId)
            <div class="relative rounded-xl overflow-hidden" style="padding-top:56.25%">
                <iframe src="https://www.youtube.com/embed/{{ $ytId }}" class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen></iframe>
            </div>
        @else
            <div class="w-full h-64 bg-purple-100 flex items-center justify-center rounded-xl">
                <i class="fas fa-image text-purple-300 text-5xl"></i>
            </div>
        @endif
    </div>
    <div>
        <h2 class="text-2xl md:text-3xl font-extrabold text-orange-600 mb-4">{{ $item->heading }}</h2>
        <div class="text-gray-600 rich-text card-desc-truncated" id="cdesc-{{ $item->id }}">
            {!! $item->description !!}
        </div>
        <button class="card-read-more mt-2" onclick="toggleDesc('cdesc-{{ $item->id }}', this)">
            Read More <i class="fas fa-chevron-down text-[10px]"></i>
        </button>
    </div>
    @endif
</div>
@endforeach
