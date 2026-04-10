@extends('admin.layouts.app')
@section('title', 'Impact Stats')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage counter stats shown on home page (e.g. 575+ Tree Plantation)</p>
    <a href="{{ route('admin.stats.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Stat
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Number</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Label</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Icon Class</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Order</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stats as $stat)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4 font-bold text-orange-600 text-lg">{{ $stat->number_value }}</td>
                <td class="py-3 px-4 text-gray-700">{{ $stat->label }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs font-mono">{{ $stat->icon_class ?? '-' }}</td>
                <td class="py-3 px-4 text-gray-500">{{ $stat->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $stat->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $stat->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.stats.edit', $stat) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.stats.destroy', $stat) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No stats yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
