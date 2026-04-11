@extends('admin.layouts.app')
@section('title', $msg ? 'Edit Message' : 'Add Message')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST" action="{{ $msg ? route('admin.president.update', $msg) : route('admin.president.store') }}" enctype="multipart/form-data">
        @csrf
        @if($msg) @method('PUT') @endif

        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Name *</label>
                <input type="text" name="president_name" value="{{ old('president_name', $msg?->president_name) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('president_name') border-red-400 @enderror"
                       placeholder="Shri Rajesh Kumar Sharma">
                @error('president_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Title *</label>
                <input type="text" name="president_title" value="{{ old('president_title', $msg?->president_title) }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('president_title') border-red-400 @enderror"
                       placeholder="President, NKB Foundation">
                @error('president_title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Profile Photo --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Profile Photo (optional)</label>
            @if($msg?->photo_url)
                <div class="flex items-center gap-4 mb-3">
                    <img src="{{ str_starts_with($msg->photo_url, 'http') ? $msg->photo_url : asset('storage/' . $msg->photo_url) }}"
                         class="w-20 h-20 rounded-full object-cover border-2 border-purple-200 shadow" alt="Profile Photo">
                    <p class="text-xs text-gray-400">Upload new to replace</p>
                </div>
            @endif
            <input type="file" name="photo" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
            <p class="text-xs text-gray-400 mt-1">Square photo recommended (JPG/PNG, max 1 MB)</p>
            @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Message *</label>
            <div id="msg-editor" style="min-height:180px;"></div>
            <textarea name="message" id="msg-input" class="hidden" required>{{ old('message', $msg?->message) }}</textarea>
            @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Signature --}}
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Signature Image (optional)</label>
            @if($msg?->signature_url)
                <div class="mb-2">
                    <img src="{{ str_starts_with($msg->signature_url, 'http') ? $msg->signature_url : asset('storage/' . $msg->signature_url) }}"
                         class="h-14 border rounded-lg p-2 bg-gray-50" alt="Signature">
                    <p class="text-xs text-gray-400 mt-1">Upload new to replace</p>
                </div>
            @endif
            <input type="file" name="signature" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
            <p class="text-xs text-gray-400 mt-1">PNG with transparent background recommended (max 512 KB)</p>
            @error('signature')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6 flex items-center">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $msg?->is_active ?? true) ? 'checked' : '' }}
                       class="rounded border-gray-300 text-purple-600 w-4 h-4">
                <span class="text-sm font-semibold text-gray-700">Active (show on home page)</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $msg ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('admin.president.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@push('scripts')
<script>
(function(){
    var quill = new Quill('#msg-editor', {
        theme: 'snow',
        placeholder: "President's message...",
        modules: { toolbar: [
            ['bold','italic','underline'],
            [{ list:'ordered' },{ list:'bullet' }],
            [{ align:[] }],
            ['clean']
        ]}
    });
    var existing = document.getElementById('msg-input').value;
    if (existing) {
        if (existing.trim().startsWith('<')) {
            quill.root.innerHTML = existing;
        } else {
            quill.setText(existing);
        }
    }
    document.querySelector('form').addEventListener('submit', function(){
        document.getElementById('msg-input').value = quill.root.innerHTML;
    });
})();
</script>
@endpush
@endsection
