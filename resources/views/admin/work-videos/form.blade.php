@extends('admin.layouts.app')
@section('title', $video ? 'Edit Video' : 'Add Video')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST" action="{{ $video ? route('admin.work-videos.update', $video) : route('admin.work-videos.store') }}">
        @csrf
        @if($video) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title', $video?->title) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="e.g. Bhandara Community Feast 2024">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Short Description</label>
            <div id="desc-editor" style="min-height:110px;"></div>
            <textarea name="description" id="desc-input" class="hidden">{{ old('description', $video?->description) }}</textarea>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">YouTube Video URL *</label>
            <input type="url" name="youtube_url" id="yt-url" value="{{ old('youtube_url', $video?->youtube_url) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="https://www.youtube.com/watch?v=...">
            @error('youtube_url')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Live YouTube preview --}}
        <div id="yt-preview" class="mb-5 hidden">
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Preview</label>
            <div class="relative rounded-xl overflow-hidden" style="padding-bottom:56.25%">
                <iframe id="yt-frame" src="" class="absolute inset-0 w-full h-full" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Custom Thumbnail URL <span class="text-gray-400 font-normal">(optional — auto-fetched from YouTube if blank)</span></label>
            <input type="url" name="thumbnail_url" value="{{ old('thumbnail_url', $video?->thumbnail_url) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="https://...">
        </div>

        <div class="grid grid-cols-3 gap-4 mb-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Post Year</label>
                <select name="post_year" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
                    @for($y = now()->year + 1; $y >= now()->year - 10; $y--)
                    <option value="{{ $y }}" {{ (int) old('post_year', $video?->post_year ?? now()->year) === $y ? 'selected' : '' }}>
                        {{ $y }}{{ $y == now()->year ? ' (Current)' : '' }}
                    </option>
                    @endfor
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $video?->sort_order ?? $nextOrder ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
            <div class="flex items-end pb-1">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $video?->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-purple-600 w-4 h-4">
                    <span class="text-sm font-semibold text-gray-700">Active</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $video ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.work-videos.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
(function(){
    var quill = new Quill('#desc-editor', {
        theme: 'snow',
        placeholder: 'Brief description shown on the card...',
        modules: { toolbar: [
            ['bold','italic','underline'],
            [{ list:'ordered' },{ list:'bullet' }],
            ['clean']
        ]}
    });
    var existing = document.getElementById('desc-input').value.trim();
    if (existing) {
        if (existing.startsWith('<')) {
            quill.clipboard.dangerouslyPasteHTML(0, existing);
        } else {
            quill.setText(existing);
        }
    }
    document.getElementById('desc-input').closest('form').addEventListener('submit', function(){
        var html = quill.root.innerHTML;
        document.getElementById('desc-input').value = (html === '<p><br></p>') ? '' : html;
    });
})();

function getYtId(url) {
    const m = url.match(/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/);
    return m ? m[1] : null;
}
const ytUrl   = document.getElementById('yt-url');
const preview = document.getElementById('yt-preview');
const frame   = document.getElementById('yt-frame');
function updatePreview() {
    const id = getYtId(ytUrl.value);
    if (id) {
        frame.src = `https://www.youtube.com/embed/${id}`;
        preview.classList.remove('hidden');
    } else {
        preview.classList.add('hidden');
        frame.src = '';
    }
}
ytUrl.addEventListener('input', updatePreview);
updatePreview();
</script>
@endpush
@endsection
