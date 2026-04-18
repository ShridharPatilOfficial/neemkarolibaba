@extends('admin.layouts.app')
@section('title', $stat ? 'Edit Stat' : 'Add Stat')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-xl">
    <form method="POST" action="{{ $stat ? route('admin.stats.update', $stat) : route('admin.stats.store') }}">
        @csrf
        @if($stat) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Number Value * (e.g. 575+, 013)</label>
            <input type="text" name="number_value" value="{{ old('number_value', $stat?->number_value) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('number_value') border-red-400 @enderror"
                   placeholder="575+">
            @error('number_value')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Label *</label>
            <input type="text" name="label" value="{{ old('label', $stat?->label) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('label') border-red-400 @enderror"
                   placeholder="Tree Plantation">
            @error('label')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Font Awesome Icon Class (optional)</label>
            <input type="text" name="icon_class" value="{{ old('icon_class', $stat?->icon_class) }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm font-mono"
                   placeholder="fas fa-tree">
            <p class="text-xs text-gray-400 mt-1">e.g. fas fa-tree, fas fa-first-aid, fas fa-book</p>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $stat?->sort_order ?? $nextOrder ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $stat?->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-purple-600 w-4 h-4">
                    <span class="text-sm font-semibold text-gray-700">Active</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $stat ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.stats.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
