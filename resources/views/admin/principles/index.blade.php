@extends('admin.layouts.app')
@section('title', 'Principles (Mission / Vision / Objectives)')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage the Mission, Vision & Objectives cards shown on the home page</p>
    <a href="{{ route('admin.principles.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Principle
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-8">#</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Icon</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Title</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Description</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-24">Theme</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-16">Order</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($principles as $p)
            @php $theme = $p->theme; @endphp
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4 text-gray-400 font-mono text-xs">{{ $p->sort_order }}</td>
                <td class="py-3 px-4">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $theme['gradient'] }} flex items-center justify-center shadow-sm">
                        <i class="fas {{ $p->icon }} text-white text-sm"></i>
                    </div>
                </td>
                <td class="py-3 px-4 font-semibold text-gray-800">{{ $p->title }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs">{{ Str::limit($p->description, 90) }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $theme['bg'] }} text-gray-700">
                        {{ ucfirst($p->color_theme) }}
                    </span>
                </td>
                <td class="py-3 px-4 text-gray-500">{{ $p->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $p->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $p->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.principles.edit', $p) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.principles.destroy', $p) }}" class="inline" onsubmit="return confirm('Delete this principle?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="8" class="py-10 text-center text-gray-400">No principles yet. Click "Add Principle" to create Mission, Vision & Objectives cards.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-xl text-sm text-blue-700 flex items-start gap-3">
    <i class="fas fa-info-circle mt-0.5 flex-shrink-0"></i>
    <span>These cards appear in the <strong>"Our Core Principles"</strong> section on the home page. Use <strong>Sort Order</strong> (0, 1, 2…) to control the display sequence.</span>
</div>
@endsection
