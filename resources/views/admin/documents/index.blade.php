@extends('admin.layouts.app')
@section('title', 'Documents')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage documents (PDF/DOCX) for the Document Gallery page</p>
    <a href="{{ route('admin.documents.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Upload Document
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Name</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Type</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Order</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $doc)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4">
                    <div class="flex items-center gap-2">
                        <i class="fas {{ $doc->file_type === 'pdf' ? 'fa-file-pdf text-red-500' : 'fa-file-word text-blue-500' }}"></i>
                        <span class="font-medium text-gray-800">{{ $doc->name }}</span>
                    </div>
                </td>
                <td class="py-3 px-4">
                    <span class="uppercase text-xs font-bold {{ $doc->file_type === 'pdf' ? 'text-red-600 bg-red-50' : 'text-blue-600 bg-blue-50' }} px-2 py-0.5 rounded">
                        {{ $doc->file_type }}
                    </span>
                </td>
                <td class="py-3 px-4 text-gray-500">{{ $doc->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $doc->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $doc->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right flex items-center justify-end gap-3">
                    <a href="{{ route('documents.view', $doc->id) }}" target="_blank" class="text-green-600 hover:text-green-800 text-xs font-semibold">View</a>
                    <a href="{{ route('admin.documents.edit', $doc) }}" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.documents.destroy', $doc) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="py-10 text-center text-gray-400">No documents uploaded yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
