@extends('admin.layouts.app')
@section('title', $principle ? 'Edit Principle' : 'Add Principle')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST" action="{{ $principle ? route('admin.principles.update', $principle) : route('admin.principles.store') }}">
        @csrf
        @if($principle) @method('PUT') @endif

        {{-- Title --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Title *</label>
            <input type="text" name="title" value="{{ old('title', $principle?->title) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('title') border-red-400 @enderror"
                   placeholder="e.g. Mission, Vision, Objectives">
            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Description --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Description *</label>
            <div id="desc-editor" style="min-height:140px;"></div>
            <textarea name="description" id="desc-input" class="hidden" required>{{ old('description', $principle?->description) }}</textarea>
            @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            {{-- Icon --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">FontAwesome Icon *</label>
                <input type="text" name="icon" value="{{ old('icon', $principle?->icon ?? 'fa-star') }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('icon') border-red-400 @enderror"
                       placeholder="fa-dove">
                <p class="text-xs text-gray-400 mt-1">
                    E.g. <code>fa-dove</code>, <code>fa-eye</code>, <code>fa-bullseye</code>, <code>fa-heart</code>
                    — see <a href="https://fontawesome.com/icons" target="_blank" class="text-purple-600 underline">fontawesome.com/icons</a>
                </p>
                @error('icon')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            {{-- Color Theme --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Color Theme *</label>
                <select name="color_theme"
                        class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('color_theme') border-red-400 @enderror">
                    @foreach($themes as $key => $theme)
                    <option value="{{ $key }}" {{ old('color_theme', $principle?->color_theme ?? 'orange') === $key ? 'selected' : '' }}>
                        {{ $theme['label'] }}
                    </option>
                    @endforeach
                </select>
                @error('color_theme')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-5">
            {{-- Link URL --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Learn More URL <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="url" name="link_url" value="{{ old('link_url', $principle?->link_url) }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                       placeholder="https://...">
            </div>

            {{-- Sort Order --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $principle?->sort_order ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
                <p class="text-xs text-gray-400 mt-1">Lower = shown first (0, 1, 2…)</p>
            </div>
        </div>

        {{-- Active --}}
        <div class="mb-6 flex items-center">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $principle?->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-purple-600 w-4 h-4">
                <span class="text-sm font-semibold text-gray-700">Active (show on home page)</span>
            </label>
        </div>

        {{-- Live Preview --}}
        <div class="mb-6 p-4 bg-gray-50 rounded-xl border border-gray-200">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Icon Preview</p>
            <div id="icon-preview" class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-500 to-red-500 flex items-center justify-center shadow">
                <i id="icon-preview-i" class="fas fa-star text-white text-lg"></i>
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $principle ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.principles.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
(function(){
    var quill = new Quill('#desc-editor', {
        theme: 'snow',
        placeholder: 'Full description text shown on the card...',
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

// Live icon preview
const iconInput = document.querySelector('input[name="icon"]');
const previewI  = document.getElementById('icon-preview-i');
if (iconInput && previewI) {
    iconInput.addEventListener('input', function () {
        previewI.className = 'fas ' + this.value.trim() + ' text-white text-lg';
    });
    // init
    previewI.className = 'fas ' + (iconInput.value.trim() || 'fa-star') + ' text-white text-lg';
}
</script>
@endpush
@endsection
