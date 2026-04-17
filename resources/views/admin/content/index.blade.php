@extends('admin.layouts.app')
@section('title', ucfirst(str_replace('-', ' ', $type)))

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3 mb-5">
    <div class="flex items-center gap-3">
        <p class="text-gray-500 text-sm">Manage {{ strtolower($cfg['label']) }} records · drag rows to reorder</p>
    </div>
    <div class="flex items-center gap-2">
        {{-- Year filter --}}
        @if(count($years))
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            <option value="{{ route('admin.content.index', $type) }}">All Years</option>
            @foreach($years as $y)
            <option value="{{ route('admin.content.index', $type) }}?year={{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
        @endif
        {{-- Status filter --}}
        <select onchange="location.href=this.value" class="text-sm border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:border-purple-400 bg-white">
            <option value="{{ route('admin.content.index', $type) }}{{ request('year') ? '?year='.request('year') : '' }}">All Status</option>
            <option value="{{ route('admin.content.index', $type) }}?{{ http_build_query(array_merge(request()->only('year'), ['status'=>'active'])) }}" {{ request('status')=='active' ? 'selected' : '' }}>Active</option>
            <option value="{{ route('admin.content.index', $type) }}?{{ http_build_query(array_merge(request()->only('year'), ['status'=>'inactive'])) }}" {{ request('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <a href="{{ route('admin.content.create', $type) }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
            <i class="fas fa-plus mr-1"></i> Add {{ $cfg['label'] }}
        </a>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-3 w-8 text-gray-400"><i class="fas fa-grip-vertical text-xs"></i></th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-24">Media</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Heading</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-24">Year</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody id="sortable-body" data-reorder-url="{{ route('admin.content.reorder', $type) }}">
            @forelse($items as $item)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition sortable-row" data-id="{{ $item->id }}">
                <td class="py-3 px-3 text-gray-300 cursor-grab drag-handle"><i class="fas fa-grip-vertical text-sm"></i></td>
                <td class="py-3 px-4">
                    @if($item->image_url)
                        <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url) }}"
                             class="w-16 h-10 object-cover rounded" alt="">
                    @elseif($item->youtube_url)
                        <i class="fab fa-youtube text-red-500 text-xl"></i>
                    @else
                        <i class="fas fa-image text-gray-300 text-xl"></i>
                    @endif
                </td>
                <td class="py-3 px-4 font-medium text-gray-800">{{ Str::limit($item->heading, 60) }}</td>
                <td class="py-3 px-4 text-gray-400 text-xs">{{ $item->created_at->format('Y') }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $item->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.content.edit', [$type, $item->id]) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.content.destroy', [$type, $item->id]) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No {{ strtolower($cfg['label']) }} records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Pagination --}}
<div class="mt-4">{{ $items->appends(request()->query())->links() }}</div>

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
