@extends('admin.layouts.app')
@section('title', $coverage ? 'Edit Coverage' : 'Add Media Coverage')
@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST" enctype="multipart/form-data"
          action="{{ $coverage ? route('admin.media-coverage.update', $coverage) : route('admin.media-coverage.store') }}">
        @csrf
        @if($coverage) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Headline / Title *</label>
            <input type="text" name="title" value="{{ old('title', $coverage?->title) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="e.g. NKB Foundation feeds 500 families in Chandigarh">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description / Summary</label>
            <div id="desc-editor" style="min-height:110px;"></div>
            <textarea name="description" id="desc-input" class="hidden">{{ old('description', $coverage?->description) }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Source / Channel Name *</label>
                <input type="text" name="source_name" value="{{ old('source_name', $coverage?->source_name) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                       placeholder="e.g. Times of India, Aaj Tak">
                @error('source_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Category *</label>
                <select name="category"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
                    @foreach($categories as $key => $label)
                    <option value="{{ $key }}" {{ old('category', $coverage?->category ?? 'news') === $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Article / Source URL <span class="text-gray-400 font-normal">(optional)</span></label>
            <input type="url" name="source_url" value="{{ old('source_url', $coverage?->source_url) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="https://timesofindia.com/...">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">YouTube Video URL <span class="text-gray-400 font-normal">(optional)</span></label>
            <input type="url" name="youtube_url" value="{{ old('youtube_url', $coverage?->youtube_url) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="https://www.youtube.com/watch?v=...">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Cover Image <span class="text-gray-400 font-normal">(optional — auto from YouTube if blank)</span></label>
            @if($coverage?->cover_image_url)
            <div class="mb-2">
                <img src="{{ str_starts_with($coverage->cover_image_url,'http') ? $coverage->cover_image_url : asset('storage/'.$coverage->cover_image_url) }}"
                     class="h-20 rounded-lg object-cover">
            </div>
            @endif
            <input type="file" name="cover_image" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Published Date</label>
                <input type="date" name="published_date"
                       value="{{ old('published_date', $coverage?->published_date?->format('Y-m-d')) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $coverage?->sort_order ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1"
                       {{ old('is_active', $coverage?->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-purple-600 w-4 h-4">
                <span class="text-sm font-semibold text-gray-700">Active (show on website)</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $coverage ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.media-coverage.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
(function(){
    var quill = new Quill('#desc-editor', {
        theme: 'snow',
        placeholder: 'Brief summary of the coverage...',
        modules: { toolbar: [
            ['bold','italic','underline'],
            [{ list:'ordered' },{ list:'bullet' }],
            ['clean']
        ]}
    });
    var existing = document.getElementById('desc-input').value;
    if (existing) {
        if (existing.trim().startsWith('<')) {
            quill.root.innerHTML = existing;
        } else {
            quill.setText(existing);
        }
    }
    document.querySelector('form').addEventListener('submit', function(){
        document.getElementById('desc-input').value = quill.root.innerHTML;
    });
})();
</script>
@endpush
@endsection
