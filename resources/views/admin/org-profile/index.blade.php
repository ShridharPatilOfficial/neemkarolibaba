@extends('admin.layouts.app')
@section('title', 'Organisation Profile')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage organisation profile table rows</p>
    <a href="{{ route('admin.org-profile.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Record
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-16">Sl No</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Document Name</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Value</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($profiles as $profile)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4 text-orange-600 font-bold">{{ $profile->sl_no }}</td>
                <td class="py-3 px-4 text-orange-600 font-medium">{{ $profile->document_name }}</td>
                <td class="py-3 px-4 text-gray-700">{{ $profile->value ?? '-' }}</td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.org-profile.edit', $profile) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.org-profile.destroy', $profile) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="py-10 text-center text-gray-400">No records yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
