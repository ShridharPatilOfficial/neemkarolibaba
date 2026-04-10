@extends('admin.layouts.app')
@section('title', $profile ? 'Edit Record' : 'Add Record')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-xl">
    <form method="POST" action="{{ $profile ? route('admin.org-profile.update', $profile) : route('admin.org-profile.store') }}">
        @csrf
        @if($profile) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Serial Number *</label>
            <input type="number" name="sl_no" value="{{ old('sl_no', $profile?->sl_no ?? $nextSl) }}" required min="1"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('sl_no') border-red-400 @enderror">
            @error('sl_no')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Document Name *</label>
            <input type="text" name="document_name" value="{{ old('document_name', $profile?->document_name) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('document_name') border-red-400 @enderror"
                   placeholder="e.g. REGISTRATION NO., Income Tax Registration...">
            @error('document_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Value / Number</label>
            <input type="text" name="value" value="{{ old('value', $profile?->value) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="e.g. IN-CH44392214903842V, Available, https://...">
        </div>
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order', $profile?->sort_order ?? 0) }}" min="0"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $profile ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.org-profile.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
