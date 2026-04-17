@extends('admin.layouts.app')
@section('title','Media Coverage')
@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <p class="text-gray-500 text-sm">News, TV, and online media coverage · drag rows to reorder</p>
    <div class="flex items-center gap-2 flex-wrap">
        {{-- Year filter --}}
        @if(count($years))
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            <option value="{{ route('admin.media-coverage.index') }}">All Years</option>
            @foreach($years as $y)
            <option value="{{ route('admin.media-coverage.index') }}?year={{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
        @endif
        {{-- Category filter --}}
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            <option value="{{ route('admin.media-coverage.index') }}{{ request('year') ? '?year='.request('year') : '' }}">All Categories</option>
            @foreach(['news'=>'News','tv'=>'TV / Video','online'=>'Online','magazine'=>'Magazine'] as $k => $v)
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(array_merge(request()->only('year'), ['category'=>$k])) }}" {{ request('category')==$k ? 'selected' : '' }}>{{ $v }}</option>
            @endforeach
        </select>
        {{-- Status filter --}}
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            <option value="{{ route('admin.media-coverage.index') }}{{ request('year') ? '?year='.request('year') : '' }}">All Status</option>
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(array_merge(request()->only('year','category'), ['status'=>'active'])) }}" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
            <option value="{{ route('admin.media-coverage.index') }}?{{ http_build_query(array_merge(request()->only('year','category'), ['status'=>'inactive'])) }}" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <a href="{{ route('admin.media-coverage.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
            <i class="fas fa-plus mr-1"></i> Add Coverage
        </a>
    </div>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-3 w-8 text-gray-400"><i class="fas fa-grip-vertical text-xs"></i></th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Image</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Title</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-28">Source</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-24">Category</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-24">Date</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
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
                <td class="py-3 px-4 font-semibold text-gray-800">{{ Str::limit($c->title,60) }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs">{{ $c->source_name }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $catColors[$c->category] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($c->category) }}
                    </span>
                </td>
                <td class="py-3 px-4 text-gray-500 text-xs">{{ $c->published_date?->format('d M Y') ?? '—' }}</td>
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
            <tr><td colspan="8" class="py-10 text-center text-gray-400">No media coverage yet.</td></tr>
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
    Sortable.create(tbody, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function() {
            const ids = Array.from(tbody.querySelectorAll('.sortable-row')).map(r => r.dataset.id);
            fetch(tbody.dataset.reorderUrl, {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content},
                body: JSON.stringify({ ids })
            });
        }
    });
})();
</script>
@endpush
@endsection
