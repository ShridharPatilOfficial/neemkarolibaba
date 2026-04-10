@extends('admin.layouts.app')
@section('title','Media Coverage')
@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">News, TV, and online media coverage of the foundation</p>
    <a href="{{ route('admin.media-coverage.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Coverage
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Image</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Title</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-28">Source</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-24">Category</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-24">Date</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($coverages as $c)
            @php
                $catColors = ['news'=>'bg-blue-100 text-blue-700','tv'=>'bg-red-100 text-red-700','online'=>'bg-green-100 text-green-700','magazine'=>'bg-purple-100 text-purple-700'];
                $img = $c->cover_image_url ? (str_starts_with($c->cover_image_url,'http') ? $c->cover_image_url : asset('storage/'.$c->cover_image_url)) : null;
                if (!$img && $c->youtube_id) $img = "https://img.youtube.com/vi/{$c->youtube_id}/mqdefault.jpg";
            @endphp
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4">
                    @if($img)
                    <img src="{{ $img }}" class="w-16 h-10 object-cover rounded-lg" alt="">
                    @else
                    <div class="w-16 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-newspaper text-gray-400 text-sm"></i>
                    </div>
                    @endif
                </td>
                <td class="py-3 px-4 font-semibold text-gray-800">{{ Str::limit($c->title,60) }}</td>
                <td class="py-3 px-4 text-gray-500 text-xs">{{ $c->source_name }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $catColors[$c->category] ?? 'bg-gray-100 text-gray-600' }}">
                        {{ ucfirst($c->category) }}
                    </span>
                </td>
                <td class="py-3 px-4 text-gray-500 text-xs">{{ $c->published_date?->format('d M Y') ?? '—' }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $c->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $c->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.media-coverage.edit', $c) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.media-coverage.destroy', $c) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="py-10 text-center text-gray-400">No media coverage yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
