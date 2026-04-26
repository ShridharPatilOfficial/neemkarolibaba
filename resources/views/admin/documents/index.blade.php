@extends('admin.layouts.app')
@section('title', 'Documents')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage documents (PDF/DOCX) for the Document Gallery page. Drag rows to reorder.</p>
    <a href="{{ route('admin.documents.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Upload Document
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm table-fixed">
        <colgroup>
            <col style="width:36px">
            <col>
            <col style="width:70px">
            <col style="width:50px">
            <col style="width:76px">
            <col style="width:140px">
        </colgroup>
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-2"></th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Name</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Type</th>
                <th class="py-3 px-4 text-center text-gray-600 font-semibold">#</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody id="docs-tbody" data-reorder-url="{{ route('documents.reorder') }}">
            @forelse($documents as $doc)
            <tr class="sortable-row border-b border-gray-50 hover:bg-gray-50 transition {{ !$doc->is_active ? 'opacity-50' : '' }}" data-id="{{ $doc->id }}">
                <td class="py-3 px-2 text-center text-gray-300 drag-handle cursor-grab" title="Drag to reorder">
                    <i class="fas fa-grip-vertical"></i>
                </td>
                <td class="py-3 px-4">
                    <div class="flex items-center gap-2">
                        <i class="fas {{ $doc->file_type === 'pdf' ? 'fa-file-pdf text-red-500' : 'fa-file-word text-blue-500' }} flex-shrink-0"></i>
                        <span class="font-medium text-gray-800 truncate">{{ $doc->name }}</span>
                        @if(!$doc->is_active)
                            <span class="text-xs text-gray-400 flex-shrink-0">(inactive)</span>
                        @endif
                    </div>
                </td>
                <td class="py-3 px-4">
                    <span class="uppercase text-xs font-bold {{ $doc->file_type === 'pdf' ? 'text-red-600 bg-red-50' : 'text-blue-600 bg-blue-50' }} px-2 py-0.5 rounded">
                        {{ $doc->file_type }}
                    </span>
                </td>
                <td class="py-3 px-4 text-center text-gray-400 font-mono text-xs sort-num">{{ $doc->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $doc->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $doc->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    @if($doc->file_type === 'pdf')
                    <button onclick="previewDoc('{{ route('admin.documents.preview', $doc->id) }}', '{{ addslashes($doc->name) }}')"
                            class="text-green-600 hover:text-green-800 text-xs font-semibold mr-2">View</button>
                    @else
                    <a href="{{ route('admin.documents.preview', $doc->id) }}" class="text-green-600 hover:text-green-800 text-xs font-semibold mr-2">Download</a>
                    @endif
                    <a href="{{ route('admin.documents.edit', $doc) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold mr-2">Edit</a>
                    <form method="POST" action="{{ route('admin.documents.destroy', $doc) }}" class="inline" onsubmit="return confirm('Delete this document?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No documents uploaded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- PDF Preview Modal --}}
<div id="docPreviewModal" class="fixed inset-0 z-[9999] hidden items-center justify-center"
     style="background:rgba(0,0,0,.85);backdrop-filter:blur(4px);">
    <div class="w-full max-w-4xl mx-4 flex flex-col" style="height:90vh;" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-3">
            <p id="docPreviewTitle" class="text-white font-bold text-sm truncate"></p>
            <button onclick="closeDocPreview()"
                    class="w-9 h-9 rounded-full bg-white/10 hover:bg-red-500 text-white flex items-center justify-center transition flex-shrink-0 ml-3">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <iframe id="docPreviewFrame" src="" class="w-full flex-1 rounded-xl border-0 bg-white"></iframe>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script>
// ── Drag-drop sort ──────────────────────────────────────────────
(function(){
    var tbody = document.getElementById('docs-tbody');
    if (!tbody) return;
    var csrfToken = function(){
        return document.querySelector('meta[name=csrf-token]')?.content ||
               document.querySelector('input[name=_token]')?.value || '';
    };
    Sortable.create(tbody, {
        handle: '.drag-handle',
        animation: 150,
        onEnd: function(){
            var ids = Array.from(tbody.querySelectorAll('.sortable-row')).map(function(r){ return r.dataset.id; });
            fetch(tbody.dataset.reorderUrl, {
                method: 'POST',
                headers: {'Content-Type':'application/json','X-CSRF-TOKEN': csrfToken()},
                body: JSON.stringify({ ids: ids })
            }).then(function(r){
                if (r.ok) {
                    tbody.querySelectorAll('.sortable-row').forEach(function(row, i){
                        var cell = row.querySelector('.sort-num');
                        if (cell) cell.textContent = i + 1;
                    });
                }
            }).catch(function(e){ console.warn('Reorder error', e); });
        }
    });
})();

// ── PDF Preview Modal ───────────────────────────────────────────
function previewDoc(url, title) {
    document.getElementById('docPreviewFrame').src = url;
    document.getElementById('docPreviewTitle').textContent = title || 'Document Preview';
    var m = document.getElementById('docPreviewModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeDocPreview() {
    document.getElementById('docPreviewFrame').src = '';
    var m = document.getElementById('docPreviewModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    document.body.style.overflow = '';
}
document.getElementById('docPreviewModal').addEventListener('click', function(e){
    if (e.target === this) closeDocPreview();
});
document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeDocPreview(); });
document.body.appendChild(document.getElementById('docPreviewModal'));
</script>
@endpush
@endsection
