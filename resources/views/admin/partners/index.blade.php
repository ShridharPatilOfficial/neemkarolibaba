@extends('admin.layouts.app')
@section('title', 'Collaborated Partners')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage partner logos shown on home page</p>
    <a href="{{ route('admin.partners.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Partner
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-16">#</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-28">Logo</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Name</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Order</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($partners as $partner)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4 text-gray-500">{{ $partner->id }}</td>
                <td class="py-3 px-4">
                    <img src="{{ str_starts_with($partner->logo_url, 'http') ? $partner->logo_url : asset('storage/' . $partner->logo_url) }}"
                         class="h-10 max-w-20 object-contain" alt="">
                </td>
                <td class="py-3 px-4 font-medium text-gray-800">{{ $partner->name }}</td>
                <td class="py-3 px-4 text-gray-500">{{ $partner->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $partner->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $partner->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.partners.edit', $partner) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.partners.destroy', $partner) }}" class="inline" onsubmit="return confirm('Delete this partner?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No partners yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
