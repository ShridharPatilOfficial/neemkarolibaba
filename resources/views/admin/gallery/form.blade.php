@extends('admin.layouts.app')
@section('title', $item ? 'Edit Gallery Item' : 'Add Gallery Item')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-xl">
    <form method="POST" action="{{ $item ? route('admin.gallery.update', $item) : route('admin.gallery.store') }}" enctype="multipart/form-data">
        @csrf
        @if($item) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Type *</label>
            <select name="type" class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm" id="typeSelect">
                <option value="image"  {{ old('type', $item?->type) === 'image'  ? 'selected' : '' }}>Image Only</option>
                <option value="video"  {{ old('type', $item?->type) === 'video'  ? 'selected' : '' }}>YouTube Video Only</option>
                <option value="both"   {{ old('type', $item?->type) === 'both'   ? 'selected' : '' }}>Both Image + Video</option>
            </select>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Headline</label>
            <input type="text" name="headline" value="{{ old('headline', $item?->headline) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="Optional headline/caption">
        </div>

        <div class="mb-5" id="imageField">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image</label>
            @if($item?->image_url)
                <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url) }}"
                     class="w-32 h-20 object-cover rounded-lg mb-2" alt="">
                <p class="text-xs text-gray-400 mb-1">Upload new to replace</p>
            @endif
            <input type="file" name="image" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
        </div>

        <div class="mb-5" id="ytField">
            <label class="block text-sm font-semibold text-gray-700 mb-1">YouTube URL</label>
            <input type="url" name="youtube_url" value="{{ old('youtube_url', $item?->youtube_url) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm font-mono"
                   placeholder="https://www.youtube.com/watch?v=...">
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
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
            <a href="{{ route('admin.gallery.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
@push('scripts')
<script>
function toggleFields() {
    const t = document.getElementById('typeSelect').value;
    document.getElementById('imageField').style.display = (t === 'video') ? 'none' : '';
    document.getElementById('ytField').style.display   = (t === 'image') ? 'none' : '';
}
document.getElementById('typeSelect').addEventListener('change', toggleFields);
toggleFields();
</script>
@endpush
