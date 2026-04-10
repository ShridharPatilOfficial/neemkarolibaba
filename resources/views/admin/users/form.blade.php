@extends('admin.layouts.app')
@section('title', $adminUser ? 'Edit Admin User' : 'Add Admin User')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-lg">
    <form method="POST" action="{{ $adminUser ? route('admin.users.update', $adminUser) : route('admin.users.store') }}">
        @csrf
        @if($adminUser) @method('PUT') @endif

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Name *</label>
            <input type="text" name="name" value="{{ old('name', $adminUser?->name) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('name') border-red-400 @enderror"
                   placeholder="Full Name">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Email *</label>
            <input type="email" name="email" value="{{ old('email', $adminUser?->email) }}" required
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('email') border-red-400 @enderror"
                   placeholder="admin@example.com">
            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Password {{ $adminUser ? '(leave blank to keep current)' : '*' }}
            </label>
            <input type="password" name="password" {{ !$adminUser ? 'required' : '' }}
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('password') border-red-400 @enderror"
                   placeholder="{{ $adminUser ? 'Enter new password to change' : 'Enter password' }}">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Confirm Password {{ $adminUser ? '(if changing)' : '*' }}
            </label>
            <input type="password" name="password_confirmation" {{ !$adminUser ? 'required' : '' }}
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                   placeholder="Repeat password">
        </div>

        @if($adminUser && $adminUser->id === Auth::guard('admin')->id())
        <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-xs text-yellow-700">
            <i class="fas fa-info-circle mr-1"></i> You are editing your own account. Changing your email will require re-login.
        </div>
        @endif

        <div class="flex gap-3">
            <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
                <i class="fas fa-save mr-1"></i> {{ $adminUser ? 'Update' : 'Create User' }}
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-2.5 px-6 rounded-lg transition text-sm">Cancel</a>
        </div>
    </form>
</div>
@endsection
