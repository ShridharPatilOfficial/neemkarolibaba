@extends('admin.layouts.app')
@section('title', isset($badge) ? 'Edit Tax Badge' : 'Add Tax Badge')

@section('content')
<div class="max-w-lg">
    <div class="mb-5">
        <a href="{{ route('admin.tax-badges.index') }}" class="text-sm text-purple-700 hover:underline flex items-center gap-1">
            <i class="fas fa-arrow-left text-xs"></i> Back to Badges
        </a>
    </div>

    @if($errors->any())
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
        <ul class="list-disc list-inside space-y-0.5">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form method="POST"
              action="{{ isset($badge) ? route('admin.tax-badges.update', $badge) : route('admin.tax-badges.store') }}">
            @csrf
            @if(isset($badge)) @method('PUT') @endif

            {{-- Label --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Short Label <span class="text-red-500">*</span></label>
                <input type="text" name="label" value="{{ old('label', $badge->label ?? '') }}" required maxlength="20"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm font-bold"
                       placeholder="e.g. 80G, 12A, CSR">
                <p class="text-xs text-gray-400 mt-1">Max 20 characters — shown as a pill badge on the donate page</p>
            </div>

            {{-- Linked Document --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Linked Document <span class="text-gray-400 font-normal">(optional)</span></label>
                <select name="document_id"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm bg-white">
                    <option value="">— No document —</option>
                    @foreach($documents as $doc)
                        <option value="{{ $doc->id }}"
                            {{ old('document_id', isset($badge) ? $badge->document_id : '') == $doc->id ? 'selected' : '' }}>
                            {{ $doc->name }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-400 mt-1">When a visitor clicks this badge, the linked document will open</p>
            </div>

            {{-- Sort Order --}}
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $badge->sort_order ?? 0) }}" min="0"
                       class="w-32 px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>

            {{-- Active --}}
            <div class="mb-6">
                <label class="flex items-center gap-3 cursor-pointer select-none">
                    <input type="checkbox" name="is_active" value="1"
                           {{ old('is_active', isset($badge) ? $badge->is_active : true) ? 'checked' : '' }}
                           class="w-4 h-4 rounded text-purple-600">
                    <span class="text-sm font-semibold text-gray-700">Active (visible on donate page)</span>
                </label>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit"
                        class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-8 rounded-lg transition text-sm">
                    <i class="fas fa-save mr-1"></i> {{ isset($badge) ? 'Update Badge' : 'Add Badge' }}
                </button>
                <a href="{{ route('admin.tax-badges.index') }}"
                   class="text-gray-500 hover:text-gray-700 text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
