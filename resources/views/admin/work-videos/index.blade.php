@extends('admin.layouts.app')
@section('title','Work in Action — Videos')
@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">YouTube videos shown in "Work in Action" section on home page</p>
    <a href="{{ route('admin.work-videos.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Video
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm table-fixed">
        <colgroup>
            <col style="width:36px">
            <col style="width:80px">
            <col>
            <col style="width:220px">
            <col style="width:56px">
            <col style="width:56px">
            <col style="width:64px">
            <col style="width:96px">
        </colgroup>
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-2"></th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Thumb</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Title</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Description</th>
                <th class="py-3 px-4 text-center text-gray-600 font-semibold">Year</th>
                <th class="py-3 px-4 text-center text-gray-600 font-semibold">#</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody id="work-videos-tbody" data-reorder-url="{{ route('admin.work-videos.reorder') }}">
            @forelse($videos as $v)
            <tr class="sortable-row border-b border-gray-50 hover:bg-gray-50 transition" data-id="{{ $v->id }}">
                <td class="py-3 px-2 text-center text-gray-300 drag-handle cursor-grab" title="Drag to reorder">
                    <i class="fas fa-grip-vertical"></i>
                </td>
                <td class="py-3 px-4">
                    @if($v->youtube_id)
                    <img src="https://img.youtube.com/vi/{{ $v->youtube_id }}/mqdefault.jpg"
                         class="w-16 h-10 object-cover rounded-lg" alt="">
                    @else
                    <div class="w-16 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fab fa-youtube text-red-400"></i>
                    </div>
                    @endif
                </td>
                <td class="py-3 px-4 font-semibold text-gray-800 truncate">{{ $v->title }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs truncate">{{ Str::limit(strip_tags($v->description), 80) }}</td>
                <td class="py-3 px-4 text-center text-gray-500 font-mono text-xs">{{ $v->post_year ?: '—' }}</td>
                <td class="py-3 px-4 text-center text-gray-400 font-mono text-xs">{{ $v->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $v->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $v->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.work-videos.edit', $v) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.work-videos.destroy', $v) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="py-10 text-center text-gray-400">No videos yet. Add some to show in "Work in Action" section.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
(function () {
    const tbody = document.getElementById('work-videos-tbody');
    if (!tbody) return;
    const csrfToken = () =>
        document.querySelector('meta[name=csrf-token]')?.content ||
        document.querySelector('input[name=_token]')?.value || '';

    Sortable.create(tbody, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function () {
            const ids = Array.from(tbody.querySelectorAll('.sortable-row')).map(r => r.dataset.id);
            fetch(tbody.dataset.reorderUrl, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken() },
                body: JSON.stringify({ ids })
            }).then(r => {
                if (!r.ok) console.warn('Reorder save failed', r.status);
                else {
                    // Update the displayed sort # in each row
                    tbody.querySelectorAll('.sortable-row').forEach((row, i) => {
                        const cell = row.querySelector('td:nth-child(5)');
                        if (cell) cell.textContent = i + 1;
                    });
                }
            }).catch(e => console.warn('Reorder error', e));
        }
    });
})();
</script>
@endpush
@endsection
