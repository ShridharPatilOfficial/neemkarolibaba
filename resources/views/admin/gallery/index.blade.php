@extends('admin.layouts.app')
@section('title', 'Gallery')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage gallery images and videos</p>
    <a href="{{ route('admin.gallery.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Item
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Preview</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Headline</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-16">Type</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Order</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4">
                    @if($item->image_url)
                        <img src="{{ str_starts_with($item->image_url, 'http') ? $item->image_url : asset('storage/' . $item->image_url) }}"
                             class="w-16 h-10 object-cover rounded" alt="">
                    @elseif($item->youtube_url)
                        <i class="fab fa-youtube text-red-500 text-2xl"></i>
                    @else
                        <i class="fas fa-image text-gray-300 text-2xl"></i>
                    @endif
                </td>
                <td class="py-3 px-4 text-gray-700">{{ $item->headline ?? '-' }}</td>
                <td class="py-3 px-4">
                    <span class="text-xs font-bold uppercase px-2 py-0.5 rounded {{ $item->type === 'image' ? 'bg-blue-100 text-blue-600' : ($item->type === 'video' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600') }}">
                        {{ $item->type }}
                    </span>
                </td>
                <td class="py-3 px-4 text-gray-500">{{ $item->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $item->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $item->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.gallery.edit', $item) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.gallery.destroy', $item) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No gallery items yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3 border-t border-gray-100">{{ $items->links() }}</div>
</div>
@endsection
