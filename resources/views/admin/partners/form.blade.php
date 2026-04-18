@extends('admin.layouts.app')
@section('title', $partner ? 'Edit Partner' : 'Add Partner')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-xl">
    <form method="POST" action="{{ $partner ? route('admin.partners.update', $partner) : route('admin.partners.store') }}" enctype="multipart/form-data">
        @csrf
        @if($partner) @method('PUT') @endif

        @if($partner?->logo_url)
        <div class="mb-5">
            <img src="{{ str_starts_with($partner->logo_url, 'http') ? $partner->logo_url : asset('storage/' . $partner->logo_url) }}"
                 class="h-16 object-contain rounded border p-2" alt="">
            <p class="text-xs text-gray-400 mt-1">Current logo — upload new to replace</p>
        </div>
        @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Partner Name *</label>
            <input type="text" name="name" value="{{ old('name', $partner?->name) }}" required placeholder="Partner Organisation Name"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('name') border-red-400 @enderror">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Logo {{ $partner ? '(optional to replace)' : '*' }}</label>
            <input type="file" name="logo" accept="image/*" {{ !$partner ? 'required' : '' }}
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
            @error('logo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Website URL</label>
            <input type="url" name="website_url" value="{{ old('website_url', $partner?->website_url) }}" placeholder="https://..."
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
        </div>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $partner?->sort_order ?? $nextOrder ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $partner?->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-purple-600 w-4 h-4">
                    <span class="text-sm font-semibold text-gray-700">Active</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $partner ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.partners.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
