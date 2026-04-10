@extends('admin.layouts.app')
@section('title', $slider ? 'Edit Slider' : 'Add Slider')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-xl">
    <form method="POST" action="{{ $slider ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}" enctype="multipart/form-data">
        @csrf
        @if($slider) @method('PUT') @endif

        @if($slider)
        <div class="mb-5">
            <img src="{{ str_starts_with($slider->image_url, 'http') ? $slider->image_url : asset('storage/' . $slider->image_url) }}"
                 class="w-full h-40 object-cover rounded-xl" alt="Current Image">
            <p class="text-xs text-gray-400 mt-1">Current image — upload a new one to replace</p>
        </div>
        @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Image {{ $slider ? '(optional to replace)' : '*' }}</label>
            <input type="file" name="image" accept="image/*" {{ !$slider ? 'required' : '' }}
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200 @error('image') border border-red-400 rounded @enderror">
            @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Caption</label>
            <input type="text" name="caption" value="{{ old('caption', $slider?->caption) }}" placeholder="Optional caption"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $slider?->sort_order ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $slider?->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-purple-600 w-4 h-4">
                    <span class="text-sm font-semibold text-gray-700">Active</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $slider ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.sliders.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
