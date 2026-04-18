@extends('admin.layouts.app')
@section('title','Media Coverage')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <p class="text-gray-500 text-sm">News, TV, and online media coverage · drag rows to reorder</p>
    <div class="flex items-center gap-2 flex-wrap">
        {{-- Year filter (always visible, default = current year) --}}
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            @for($y = $currentYear + 2; $y >= $currentYear - 10; $y--)
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(array_merge(request()->only('category','status'), ['year' => $y])) }}"
                {{ $year == $y ? 'selected' : '' }}>
                {{ $y }}{{ $y == $currentYear ? ' (Current)' : '' }}
            </option>
            @endfor
        </select>
        {{-- Category filter --}}
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(['year' => $year]) }}">All Categories</option>
            @foreach(['news'=>'News','tv'=>'TV / Video','online'=>'Online','magazine'=>'Magazine'] as $k => $v)
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(['year' => $year, 'category' => $k]) }}"
                {{ request('category') == $k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
        {{-- Status filter --}}
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(array_merge(request()->only('category'), ['year' => $year])) }}">All Status</option>
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(array_merge(request()->only('category'), ['year' => $year, 'status' => 'active'])) }}"
                {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(array_merge(request()->only('category'), ['year' => $year, 'status' => 'inactive'])) }}"
                {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <a href="{{ route('admin.media-coverage.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
            <i class="fas fa-plus mr-1"></i> Add Coverage
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm" style="table-layout:fixed">
        <colgroup>
            <col style="width:36px">
            <col style="width:80px">
            <col style="width:160px">{{-- Title --}}
            <col>{{-- Description takes remaining --}}
            <col style="width:100px">{{-- Source --}}
            <col style="width:80px">{{-- Category --}}
            <col style="width:48px">{{-- Sort # --}}
            <col style="width:60px">{{-- Active --}}
            <col style="width:100px">{{-- Actions --}}
        </colgroup>
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-3 text-gray-400"><i class="fas fa-grip-vertical text-xs"></i></th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Image</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Title</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Description</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Source</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Category</th>
                <th class="py-3 px-3 text-center text-gray-600 font-semibold">#</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody id="sortable-body" data-reorder-url="{{ route('admin.media-coverage.reorder') }}">
            @forelse($coverages as $c)
            @php
                $catColors = ['news'=>'bg-blue-100 text-blue-700','tv'=>'bg-red-100 text-red-700','online'=>'bg-green-100 text-green-700','magazine'=>'bg-purple-100 text-purple-700'];
                $img = $c->cover_image_url ? (str_starts_with($c->cover_image_url,'http') ? $c->cover_image_url : asset('storage/'.$c->cover_image_url)) : null;
                if (!$img && $c->youtube_id) $img = "https://img.youtube.com/vi/{$c->youtube_id}/mqdefault.jpg";
            @endphp
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition sortable-row" data-id="{{ $c->id }}">
                <td class="py-3 px-3 text-gray-300 cursor-grab drag-handle"><i class="fas fa-grip-vertical text-sm"></i></td>
                <td class="py-3 px-4">
                    @if($img)
                    <img src="{{ $img }}" class="w-16 h-10 object-cover rounded-lg" alt="">
                    @else
                    <div class="w-16 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-newspaper text-gray-400 text-sm"></i>
                    </div>
                    @endif
                </td>
                <td class="py-3 px-4 font-semibold text-gray-800 truncate" title="{{ $c->title }}">{{ $c->title }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs truncate" title="{{ strip_tags($c->description) }}">{{ Str::limit(strip_tags($c->description), 80) }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs truncate">{{ $c->source_name }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $catColors[$c->category] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($c->category) }}
                    </span>
                </td>
                <td class="py-3 px-3 text-center text-gray-500 text-xs font-mono font-semibold">{{ $c->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $c->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $c->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.media-coverage.edit', $c) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.media-coverage.destroy', $c) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="py-16 text-center text-gray-400">
                    <i class="fas fa-calendar-times text-4xl mb-3 block text-gray-200"></i>
                    No media coverage found for <strong>{{ $year }}</strong>.
                    <a href="{{ route('admin.media-coverage.create') }}" class="text-purple-600 hover:underline ml-1">Add one?</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-4">{{ $coverages->appends(request()->query())->links() }}</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function() {
    const tbody = document.getElementById('sortable-body');
    if (!tbody) return;
    const csrfToken = () => document.querySelector('meta[name=csrf-token]')?.content
                          || document.querySelector('input[name=_token]')?.value
                          || '';
    Sortable.create(tbody, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function() {
            const ids = Array.from(tbody.querySelectorAll('.sortable-row')).map(r => r.dataset.id);
            fetch(tbody.dataset.reorderUrl, {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken()},
                body: JSON.stringify({ ids })
            }).then(r => {
                if (!r.ok) console.warn('Reorder save failed', r.status);
            }).catch(e => console.warn('Reorder error', e));
        }
    });
})();
</script>
@endpush
@endsection
