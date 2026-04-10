@extends('admin.layouts.app')
@section('title', $document ? 'Edit Document' : 'Upload Document')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-xl">
    <form method="POST" action="{{ $document ? route('admin.documents.update', $document) : route('admin.documents.store') }}" enctype="multipart/form-data">
        @csrf
        @if($document) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Document Name *</label>
            <input type="text" name="name" value="{{ old('name', $document?->name) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('name') border-red-400 @enderror"
                   placeholder="e.g. 12A Certificate, 80G Certificate">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">File {{ $document ? '(optional to replace)' : '*' }}</label>
            @if($document)
                <div class="flex items-center gap-2 mb-2 p-2 bg-gray-50 rounded-lg">
                    <i class="fas {{ $document->file_type === 'pdf' ? 'fa-file-pdf text-red-500' : 'fa-file-word text-blue-500' }}"></i>
                    <span class="text-sm text-gray-600">{{ $document->name }}.{{ $document->file_type }}</span>
                    <a href="{{ route('documents.view', $document->id) }}" target="_blank" class="ml-auto text-xs text-purple-600 hover:underline">View</a>
                </div>
            @endif
            <input type="file" name="file" accept=".pdf,.doc,.docx" {{ !$document ? 'required' : '' }}
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
            <p class="text-xs text-gray-400 mt-1">Accepted: PDF, DOC, DOCX (max 5MB). PDF will open in browser; DOCX will download.</p>
            @error('file')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Sort Order</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $document?->sort_order ?? 0) }}" min="0"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $document?->is_active ?? true) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-purple-600 w-4 h-4">
                    <span class="text-sm font-semibold text-gray-700">Active</span>
                </label>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $document ? 'Update' : 'Upload' }}
            </button>
            <a href="{{ route('admin.documents.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
