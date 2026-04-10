@extends('admin.layouts.app')
@section('title','Work in Action — Videos')
@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">YouTube videos shown in "Work in Action" section on home page</p>
    <a href="{{ route('admin.work-videos.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Video
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Thumb</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Title</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Description</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-16">Order</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($videos as $v)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4">
                    @if($v->youtube_id)
                    <img src="https://img.youtube.com/vi/{{ $v->youtube_id }}/mqdefault.jpg"
                         class="w-16 h-10 object-cover rounded-lg" alt="">
                    @else
                    <div class="w-16 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                        <i class="fab fa-youtube text-red-400"></i>
                    </div>
                    @endif
                </td>
                <td class="py-3 px-4 font-semibold text-gray-800">{{ $v->title }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs">{{ Str::limit($v->description, 80) }}</td>
                <td class="py-3 px-4 text-gray-500">{{ $v->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $v->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $v->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.work-videos.edit', $v) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.work-videos.destroy', $v) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No videos yet. Add some to show in "Work in Action" section.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
