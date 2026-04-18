@extends('admin.layouts.app')
@section('title', ($item ? 'Edit' : 'Add') . ' ' . $cfg['label'])

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST"
          action="{{ $item ? route('admin.content.update', [$type, $item->id]) : route('admin.content.store', $type) }}"
          enctype="multipart/form-data">
        @csrf
        @if($item) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Heading *</label>
            <input type="text" name="heading" value="{{ old('heading', $item?->heading) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('heading') border-red-400 @enderror"
                   placeholder="Enter heading...">
            @error('heading')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description *</label>
            <div id="desc-editor" style="min-height:140px;"></div>
            <textarea name="description" id="desc-input" class="hidden" >{{ old('description', $item?->description) }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image (optional)</label>
            @if($item?->image_url)
                <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url) }}"
                     class="w-40 h-24 object-cover rounded-lg mb-2" alt="">
                <p class="text-xs text-gray-400 mb-1">Upload new to replace</p>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
            @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">YouTube URL (optional)</label>
            <input type="url" name="youtube_url" value="{{ old('youtube_url', $item?->youtube_url) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm font-mono"
                   placeholder="https://www.youtube.com/watch?v=...">
            <p class="text-xs text-gray-400 mt-1">You can add both image AND YouTube URL — both will be displayed</p>
        </div>

        <div class="grid grid-cols-3 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Year *</label>
                <select name="post_year" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm bg-white">
                    @php $selYear = old('post_year', $item?->post_year ?? date('Y')) @endphp
                    @for($y = date('Y') + 2; $y >= date('Y') - 10; $y--)
                    <option value="{{ $y }}" {{ $selYear == $y ? 'selected' : '' }}>
                        {{ $y }}{{ $y == date('Y') ? ' (Current)' : '' }}
                    </option>
                    @endfor
                </select>
                @error('post_year')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $item?->sort_order ?? $nextOrder ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $item?->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-purple-600 w-4 h-4">
                    <span class="text-sm font-semibold text-gray-700">Active</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $item ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.content.index', $type) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
(function(){
    var quill = new Quill('#desc-editor', {
        theme: 'snow',
        placeholder: 'Enter detailed description...',
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
</script>
@endpush
@endsection
