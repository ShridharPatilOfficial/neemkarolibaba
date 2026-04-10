@extends('admin.layouts.app')
@section('title', 'Founder Members')

@section('content')
<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage founder/team members</p>
    <a href="{{ route('admin.members.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Member
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Photo</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Name</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Role</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Order</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-20">Active</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-24">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4">
                    @if($member->photo_url)
                        <img src="{{ str_starts_with($member->photo_url, 'http') ? $member->photo_url : asset('storage/' . $member->photo_url) }}"
                             class="w-10 h-10 rounded-full object-cover" alt="">
                    @else
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-user text-purple-400 text-sm"></i>
                        </div>
                    @endif
                </td>
                <td class="py-3 px-4 font-medium text-gray-800">{{ $member->name }}</td>
                <td class="py-3 px-4 text-gray-500">{{ $member->role }}</td>
                <td class="py-3 px-4 text-gray-500">{{ $member->sort_order }}</td>
                <td class="py-3 px-4">
                    <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $member->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                        {{ $member->is_active ? 'Yes' : 'No' }}
                    </span>
                </td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.members.edit', $member) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    <form method="POST" action="{{ route('admin.members.destroy', $member) }}" class="inline" onsubmit="return confirm('Delete?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="py-10 text-center text-gray-400">No members yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
