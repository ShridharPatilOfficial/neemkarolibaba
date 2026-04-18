@extends('admin.layouts.app')
@section('title', $objective ? 'Edit Objective' : 'Add Objective')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST"
          action="{{ $objective ? route('admin.trust-objectives.update', $objective) : route('admin.trust-objectives.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($objective) @method('PUT') @endif

        {{-- Title --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title', $objective?->title) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('title') border-red-400 @enderror"
                   placeholder="e.g. Youth Empowerment & Education">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Description --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description *</label>
            <div id="desc-editor" style="min-height:160px;"></div>
            <textarea name="description" id="desc-input" class="hidden" required>{{ old('description', $objective?->description) }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Image (optional) --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image <span class="text-gray-400 font-normal">(optional)</span></label>

            @if($objective?->image)
            <div class="mb-3 flex items-start gap-4">
                <img src="{{ asset('storage/'.$objective->image) }}" alt="Current image"
                     class="w-32 h-24 object-cover rounded-lg border border-gray-200">
                <div>
                    <p class="text-xs text-gray-500 mb-2">Current image</p>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-red-500 w-4 h-4">
                        <span class="text-xs text-red-600 font-semibold">Remove image</span>
                    </label>
                </div>
            </div>
            @endif

            <input type="file" name="image" accept="image/*"
                   class="w-full text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 @error('image') border border-red-400 rounded-lg @enderror">
            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP — max 2 MB. Leave blank to keep no image.</p>
            @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            {{-- Sort Order --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $objective?->sort_order ?? $nextOrder ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
                <p class="text-xs text-gray-400 mt-1">Lower = shown first (1, 2, 3…)</p>
            </div>

            {{-- Active --}}
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', $objective?->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-purple-600 w-4 h-4">
                    <span class="text-sm font-semibold text-gray-700">Active (visible on page)</span>
                </label>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $objective ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.trust-objectives.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
(function(){
    var quill = new Quill('#desc-editor', {
        theme: 'snow',
        placeholder: 'Describe this objective in detail...',
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
