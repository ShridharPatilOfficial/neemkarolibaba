@extends('admin.layouts.app')
@section('title', 'Admin Users')

@section('content')
@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
@endif

<div class="flex justify-between items-center mb-5">
    <p class="text-gray-500 text-sm">Manage admin panel users</p>
    <a href="{{ route('admin.users.create') }}" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-lg text-sm transition">
        <i class="fas fa-plus mr-1"></i> Add Admin User
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Name</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold">Email</th>
                <th class="py-3 px-4 text-left text-gray-600 font-semibold w-36">Created</th>
                <th class="py-3 px-4 text-right text-gray-600 font-semibold w-28">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr class="border-b border-gray-50 hover:bg-gray-50 transition">
                <td class="py-3 px-4 font-medium text-gray-800">
                    {{ $user->name }}
                    @if($user->id === Auth::guard('admin')->id())
                        <span class="ml-2 text-xs bg-purple-100 text-purple-600 font-bold px-2 py-0.5 rounded-full">You</span>
                    @endif
                </td>
                <td class="py-3 px-4 text-gray-500">{{ $user->email }}</td>
                <td class="py-3 px-4 text-gray-400 text-xs">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                <td class="py-3 px-4 text-right">
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600 hover:text-blue-800 mr-2 text-xs font-semibold">Edit</a>
                    @if($user->id !== Auth::guard('admin')->id())
                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline" onsubmit="return confirm('Delete this admin user?')">
                        @csrf @method('DELETE')
                        <button class="text-red-500 hover:text-red-700 text-xs font-semibold">Delete</button>
                    </form>
                    @else
                    <span class="text-gray-300 text-xs">Delete</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="4" class="py-10 text-center text-gray-400">No admin users found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
