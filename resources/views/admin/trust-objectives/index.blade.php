@extends('admin.layouts.app')
@section('title', 'Objectives of the Trust')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage the objectives displayed on the "Objectives of the Trust" page</p>
    <a href="{{ route('admin.trust-objectives.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Objective
    </a>
</div>

@if(session('success'))
<div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded-lg text-sm">
    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-12">#</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-16">Image</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Title</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold hidden md:table-cell">Description</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-28">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($objectives as $obj)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4 text-gray-400 font-mono text-xs">{{ $obj->sort_order }}</td>
                <td class="py-3 px-4">
                    @if($obj->image)
                    <img src="{{ asset('storage/'.$obj->image) }}" alt="{{ $obj->title }}"
                         class="w-12 h-10 object-cover rounded-lg border border-gray-200">
                    @else
                    <div class="w-12 h-10 rounded-lg bg-gray-100 border border-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-gray-300 text-xs"></i>
                    </div>
                    @endif
                </td>
                <td class="py-3 px-4 font-semibold text-gray-800">{{ $obj->title }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs hidden md:table-cell">{{ Str::limit(strip_tags($obj->description), 90) }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $obj->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $obj->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.trust-objectives.edit', $obj) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.trust-objectives.destroy', $obj) }}" class="inline"
                          onsubmit="return confirm('Delete this objective?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="py-10 text-center text-gray-400">No objectives yet. Click "Add Objective" to get started.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-700 flex items-start gap-3">
    <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
    <span>These objectives appear on the <strong>Objectives of the Trust</strong> page (under About Us). Use <strong>Sort Order</strong> (1, 2, 3…) to control the display sequence.</span>
</div>
@endsection
