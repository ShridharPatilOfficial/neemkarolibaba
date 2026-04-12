@foreach($coverages as $c)
@php
    $img = $c->cover_image_url ? (str_starts_with($c->cover_image_url,'http') ? $c->cover_image_url : asset('storage/'.$c->cover_image_url)) : null;
    if (!$img && $c->youtube_id) $img = "https://img.youtube.com/vi/{$c->youtube_id}/maxresdefault.jpg";
    if (!$img) $img = 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=600&q=80';
    $catIcon  = ['news'=>'fa-newspaper','tv'=>'fab fa-youtube','online'=>'fa-globe','magazine'=>'fa-book-open'][$c->category] ?? 'fa-newspaper';
    $catColor = ['news'=>'bg-blue-600','tv'=>'bg-red-600','online'=>'bg-green-600','magazine'=>'bg-purple-600'][$c->category] ?? 'bg-gray-600';
    $catLabel = \App\Models\MediaCoverage::categories()[$c->category] ?? 'News';
    $hasVideo = (bool)$c->youtube_id;
    $hasLink  = (bool)$c->source_url;
    $horizontal = $horizontal ?? false;
@endphp

@if($horizontal)
{{-- ── Horizontal card (media page) ──────────────────────────── --}}
<div class="media-card group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100
            hover:shadow-lg hover:border-orange-200 transition-all duration-300
            flex flex-row gap-0">

    {{-- Thumbnail (fixed width left panel) --}}
    <div class="relative flex-shrink-0 overflow-hidden bg-gray-100" style="width:220px; height:160px;">
        <img src="{{ $img }}" alt="{{ $c->title }}"
             class="group-hover:scale-105 transition-transform duration-500 cursor-zoom-in"
             onclick="imgLb(this)" data-full="{{ $img }}" data-caption="{{ $c->title }}"
             style="width:100%;height:100%;object-fit:cover;display:block;">

        {{-- Category badge --}}
        <span class="absolute top-2 left-2 {{ $catColor }} text-white text-[10px] font-bold px-2 py-0.5 rounded-full flex items-center gap-1 z-10">
            <i class="{{ $catIcon }} text-[9px]"></i> {{ $catLabel }}
        </span>

        {{-- Play overlay --}}
        @if($hasVideo)
        <button onclick="openMediaModal('{{ $c->youtube_id }}','{{ addslashes($c->title) }}')"
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity z-10">
            <div class="w-12 h-12 bg-red-600 rounded-full flex items-center justify-center shadow-xl hover:bg-red-700 transition">
                <i class="fas fa-play text-white ml-1"></i>
            </div>
        </button>
        @endif
    </div>

    {{-- Content (right side) --}}
    <div class="flex flex-col flex-1 p-4 min-w-0">
        {{-- Source + date --}}
        <div class="flex items-center gap-2 mb-2 flex-wrap">
            <span class="text-[10px] font-semibold text-orange-600 flex items-center gap-1">
                <i class="fas fa-broadcast-tower text-[9px]"></i> {{ $c->source_name }}
            </span>
            @if($c->published_date)
            <span class="text-[10px] text-gray-400">· {{ $c->published_date->format('d M Y') }}</span>
            @endif
        </div>

        {{-- Title --}}
        <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2 group-hover:text-orange-600 transition-colors">{{ $c->title }}</h3>

        {{-- Description --}}
        @if($c->description)
        <div class="text-gray-500 text-xs flex-1 rich-text mb-3">{!! $c->description !!}</div>
        @else
        <div class="flex-1"></div>
        @endif

        {{-- Action buttons --}}
        <div class="flex items-center gap-2 flex-wrap mt-auto">
            @if($hasVideo)
            <button onclick="openMediaModal('{{ $c->youtube_id }}','{{ addslashes($c->title) }}')"
                    class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                <i class="fab fa-youtube text-xs"></i> Watch
            </button>
            @endif
            @if($hasLink)
            <a href="{{ $c->source_url }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                <i class="fas fa-external-link-alt text-xs"></i> Read Article
            </a>
            @endif
        </div>
    </div>
</div>

@else
{{-- ── Vertical card (home page) ───────────────────────────────── --}}
<div class="media-card group bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">
    {{-- Thumbnail --}}
    <div class="relative overflow-hidden h-48 bg-gray-100">
        <img src="{{ $img }}" alt="{{ $c->title }}"
             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 cursor-zoom-in"
             onclick="imgLb(this)" data-full="{{ $img }}" data-caption="{{ $c->title }}"
             style="cursor:zoom-in;">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>

        <span class="absolute top-3 left-3 {{ $catColor }} text-white text-[10px] font-bold px-2 py-1 rounded-full flex items-center gap-1">
            <i class="{{ $catIcon }} text-[9px]"></i> {{ $catLabel }}
        </span>

        @if($hasVideo)
        <button onclick="openMediaModal('{{ $c->youtube_id }}','{{ addslashes($c->title) }}')"
                class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
            <div class="w-14 h-14 bg-red-600 rounded-full flex items-center justify-center shadow-2xl hover:bg-red-700 transition">
                <i class="fas fa-play text-white text-lg ml-1"></i>
            </div>
        </button>
        @endif

        <div class="absolute bottom-3 left-3 right-3 flex items-center justify-between">
            <span class="bg-black/50 backdrop-blur-sm text-white text-[10px] font-semibold px-2 py-1 rounded-lg">
                <i class="fas fa-broadcast-tower text-orange-400 mr-1"></i>{{ $c->source_name }}
            </span>
            @if($c->published_date)
            <span class="bg-black/50 backdrop-blur-sm text-white text-[10px] px-2 py-1 rounded-lg">
                {{ $c->published_date->format('d M Y') }}
            </span>
            @endif
        </div>
    </div>

    <div class="p-5 flex flex-col flex-1">
        <h3 class="font-bold text-gray-900 text-sm leading-snug mb-2 line-clamp-2">{{ $c->title }}</h3>
        @if($c->description)
        <div class="text-gray-500 text-xs mb-4 flex-1 rich-text">{!! $c->description !!}</div>
        @else
        <div class="flex-1"></div>
        @endif

        <div class="flex items-center gap-2 mt-auto pt-3 border-t border-gray-100 flex-wrap">
            @if($hasVideo)
            <button onclick="openMediaModal('{{ $c->youtube_id }}','{{ addslashes($c->title) }}')"
                    class="inline-flex items-center gap-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold px-3 py-1.5 rounded-lg transition">
                <i class="fab fa-youtube text-xs"></i> Watch
            </button>
            @endif
            @if($hasLink)
            <a href="{{ $c->source_url }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-1.5 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs font-bold px-3 py-1.5 rounded-lg transition">
                <i class="fas fa-external-link-alt text-xs"></i> Read Article
            </a>
            @endif
        </div>
    </div>
</div>
@endif

@endforeach
