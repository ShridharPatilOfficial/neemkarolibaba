<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - NKB Admin</title>
    @php $adminFavicon = \Illuminate\Support\Facades\Storage::exists(\App\Models\SiteSetting::get('header_photo','')) ? \Illuminate\Support\Facades\Storage::url(\App\Models\SiteSetting::get('header_photo','')) : asset('favicon.svg'); @endphp
    <link rel="icon" href="{{ $adminFavicon }}" type="image/jpeg">
    <link rel="shortcut icon" href="{{ $adminFavicon }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <style>
        .admin-nav-link { display:flex; align-items:center; gap:10px; padding:10px 16px; border-radius:8px; font-size:0.82rem; font-weight:500; color:#cbd5e1; transition:all 0.2s; }
        .admin-nav-link:hover, .admin-nav-link.active { background:#1e1b4b; color:#fff; }
        .admin-nav-link i { width:18px; text-align:center; }
        .admin-section-title { font-size:0.65rem; font-weight:700; color:#64748b; text-transform:uppercase; letter-spacing:0.1em; padding:12px 16px 4px; }
        .admin-content { flex:1; overflow-y:auto; background:#f1f5f9; }
    </style>
    @stack('styles')
    {{-- Quill Rich Text Editor --}}
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
</head>
<body class="font-sans bg-gray-100" style="display:flex; min-height:100vh;">

{{-- ─── Sidebar ──────────────────────────────────────────────────── --}}
<aside class="admin-sidebar bg-gray-900 flex flex-col" style="overflow-y:auto;">
    <!-- Logo -->
    <div class="flex items-center gap-3 p-4 border-b border-gray-700">
        <img src="{{ $adminFavicon }}" alt="NKB" class="w-9 h-9 rounded-lg flex-shrink-0 object-cover object-top">
        <div>
            <p class="text-white font-bold text-sm leading-tight">NKB Foundation</p>
            <p class="text-gray-400 text-xs">Admin Panel</p>
        </div>
    </div>

    <!-- Nav -->
    <nav class="flex-1 py-4 px-2 space-y-0.5 overflow-y-auto">

        <p class="admin-section-title">Overview</p>
        <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <a href="{{ route('admin.analytics') }}" class="admin-nav-link {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
            <i class="fas fa-chart-line"></i> Visitor Analytics
        </a>
        <a href="{{ route('admin.submissions.join-us') }}" class="admin-nav-link {{ request()->routeIs('admin.submissions.join-us') ? 'active' : '' }}">
            <i class="fas fa-user-plus"></i> Join Us
            @php $unreadJoin = \App\Models\JoinUsSubmission::where('is_read', false)->count(); @endphp
            @if($unreadJoin > 0)
                <span class="ml-auto bg-orange-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $unreadJoin }}</span>
            @endif
        </a>
        <a href="{{ route('admin.submissions.contact') }}" class="admin-nav-link {{ request()->routeIs('admin.submissions.contact') ? 'active' : '' }}">
            <i class="fas fa-envelope"></i> Contact Us
            @php $unreadContact = \App\Models\ContactSubmission::where('is_read', false)->count(); @endphp
            @if($unreadContact > 0)
                <span class="ml-auto bg-orange-500 text-white text-xs px-1.5 py-0.5 rounded-full">{{ $unreadContact }}</span>
            @endif
        </a>

        <p class="admin-section-title">Home Page</p>
        <a href="{{ route('admin.settings') }}" class="admin-nav-link {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Site Settings
        </a>
        <a href="{{ route('admin.sliders.index') }}" class="admin-nav-link {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
            <i class="fas fa-images"></i> Sliders
        </a>
        <a href="{{ route('admin.partners.index') }}" class="admin-nav-link {{ request()->routeIs('admin.partners*') ? 'active' : '' }}">
            <i class="fas fa-handshake"></i> Partners
        </a>
        <a href="{{ route('admin.stats.index') }}" class="admin-nav-link {{ request()->routeIs('admin.stats*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Impact Stats
        </a>
        <a href="{{ route('admin.president.index') }}" class="admin-nav-link {{ request()->routeIs('admin.president*') ? 'active' : '' }}">
            <i class="fas fa-user-tie"></i> President Message
        </a>
        <a href="{{ route('admin.principles.index') }}" class="admin-nav-link {{ request()->routeIs('admin.principles*') ? 'active' : '' }}">
            <i class="fas fa-layer-group"></i> Principles
        </a>

        <p class="admin-section-title">About Us</p>
        <a href="{{ route('admin.members.index') }}" class="admin-nav-link {{ request()->routeIs('admin.members*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Founder Members
        </a>
        <a href="{{ route('admin.org-profile.index') }}" class="admin-nav-link {{ request()->routeIs('admin.org-profile*') ? 'active' : '' }}">
            <i class="fas fa-building"></i> Org Profile
        </a>
        <a href="{{ route('admin.trust-objectives.index') }}" class="admin-nav-link {{ request()->routeIs('admin.trust-objectives*') ? 'active' : '' }}">
            <i class="fas fa-list-ul"></i> Trust Objectives
        </a>
        <a href="{{ route('admin.documents.index') }}" class="admin-nav-link {{ request()->routeIs('admin.documents*') ? 'active' : '' }}">
            <i class="fas fa-file-alt"></i> Documents
        </a>

        <p class="admin-section-title">Content</p>
        <a href="{{ route('admin.content.index', 'activities') }}" class="admin-nav-link {{ request()->is('admin/content/activities*') ? 'active' : '' }}">
            <i class="fas fa-hands-helping"></i> Activities
        </a>
        <a href="{{ route('admin.content.index', 'events') }}" class="admin-nav-link {{ request()->is('admin/content/events*') ? 'active' : '' }}">
            <i class="fas fa-calendar-alt"></i> Events
        </a>
        <a href="{{ route('admin.content.index', 'future-plans') }}" class="admin-nav-link {{ request()->is('admin/content/future-plans*') ? 'active' : '' }}">
            <i class="fas fa-rocket"></i> Future Plans
        </a>
        <a href="{{ route('admin.gallery.index') }}" class="admin-nav-link {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
            <i class="fas fa-photo-film"></i> Gallery
        </a>
        <a href="{{ route('admin.work-videos.index') }}" class="admin-nav-link {{ request()->routeIs('admin.work-videos*') ? 'active' : '' }}">
            <i class="fas fa-video"></i> Work in Action
        </a>
        <a href="{{ route('admin.media-coverage.index') }}" class="admin-nav-link {{ request()->routeIs('admin.media-coverage*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> Media Coverage
        </a>

        <p class="admin-section-title">Finance</p>
        <a href="{{ route('admin.donate.index') }}" class="admin-nav-link {{ request()->routeIs('admin.donate*') ? 'active' : '' }}">
            <i class="fas fa-donate"></i> Donate Settings
        </a>
        <a href="{{ route('admin.tax-badges.index') }}" class="admin-nav-link {{ request()->routeIs('admin.tax-badges*') ? 'active' : '' }}">
            <i class="fas fa-certificate"></i> Tax Badges
        </a>

        <p class="admin-section-title">System</p>
        <a href="{{ route('admin.users.index') }}" class="admin-nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
            <i class="fas fa-user-shield"></i> Admin Users
        </a>
    </nav>

    <!-- User / Logout -->
    <div class="border-t border-gray-700 p-4">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 bg-purple-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white text-xs"></i>
            </div>
            <div>
                <p class="text-white text-xs font-semibold">{{ auth('admin')->user()->name }}</p>
                <p class="text-gray-400 text-xs truncate max-w-32">{{ auth('admin')->user()->email }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-2 text-gray-400 hover:text-red-400 text-xs py-1.5 transition">
                <i class="fas fa-sign-out-alt"></i> Sign Out
            </button>
        </form>
    </div>
</aside>

{{-- ─── Main Content ────────────────────────────────────────────── --}}
<div class="admin-content flex flex-col">
    <!-- Top Bar -->
    <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between sticky top-0 z-10">
        <div>
            <h1 class="font-bold text-gray-900 text-lg">@yield('title', 'Dashboard')</h1>
            @hasSection('breadcrumb')
            <div class="text-xs text-gray-400 mt-0.5">@yield('breadcrumb')</div>
            @endif
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank" class="text-xs text-gray-500 hover:text-purple-700 flex items-center gap-1">
                <i class="fas fa-external-link-alt"></i> View Site
            </a>
        </div>
    </header>

    <!-- Flash Messages -->
    <div class="px-6 pt-4">
        @if(session('success'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm flex items-center gap-2">
            <i class="fas fa-check-circle text-green-500"></i> {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-4 p-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm flex items-center gap-2">
            <i class="fas fa-exclamation-circle text-red-500"></i> {{ session('error') }}
        </div>
        @endif
    </div>

    <div class="flex-1 p-6">
        @yield('content')
    </div>
</div>

{{-- Quill Rich Text Editor --}}
<script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
<style>
/* Quill toolbar styling to match admin theme */
.ql-toolbar.ql-snow { border:1px solid #e5e7eb; border-radius:8px 8px 0 0; background:#f9fafb; }
.ql-container.ql-snow { border:1px solid #e5e7eb; border-top:0; border-radius:0 0 8px 8px; font-family:'Poppins',sans-serif; font-size:0.875rem; min-height:120px; }
.ql-editor { min-height:120px; }
.ql-editor p { margin-bottom:0.5em; }
</style>
@stack('scripts')
</body>
</html>
