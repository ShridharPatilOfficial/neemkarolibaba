@extends('layouts.app')
@section('title', 'Join Us — Volunteer with NKB Foundation Worldwide')
@section('meta_desc', 'Join Neem Karoli Baba Foundation Worldwide as a volunteer or member. Be part of our mission to serve the poor, uplift communities, and spread love through seva across India.')
@section('meta_keywords', 'join NKB Foundation, volunteer India NGO, become member NKB, seva volunteer, charity volunteer India, Neem Karoli Baba seva, NGO membership India')
@section('canonical', route('join-us'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Join Us — Neem Karoli Baba Foundation Worldwide",
  "url": "{{ route('join-us') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "Join Us", "item": "{{ route('join-us') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Join Us</h1>
        <p class="text-purple-200">Neem Karoli Baba Foundation Worldwide</p>
        <nav class="flex mt-3 text-sm">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">Join Us</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left: Info -->
        <div class="relative overflow-hidden rounded-2xl">
            <img src="https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=800&auto=format"
                 alt="Support Us" class="w-full h-full object-cover min-h-64 opacity-30 absolute inset-0">
            <div class="relative z-10 p-10 bg-gradient-to-br from-purple-900 to-purple-700 text-white rounded-2xl">
                <h2 class="text-3xl font-extrabold text-orange-400 mb-2">Support Us</h2>
                <div class="w-12 h-1 bg-blue-400 mb-6"></div>
                <p class="text-purple-200 leading-relaxed text-sm">
                    Become a part of our mission to uplift communities and make a difference.
                    Volunteer, donate, or collaborate to help create lasting positive change.
                    Your support can transform lives.
                </p>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('join-us.store') }}" novalidate>
                @csrf

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Your Full Name"
                           class="form-input @error('name') border-red-400 @enderror">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="10-digit Indian mobile number"
                           maxlength="10"
                           class="form-input @error('phone') border-red-400 @enderror">
                    @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address <span class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com"
                           class="form-input @error('email') border-red-400 @enderror">
                    @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                    <textarea name="message" rows="4" placeholder="Tell us how you'd like to help..."
                              class="form-input resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">
                        Security: {{ $num1 }} + {{ $num2 }} = ? <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="captcha" value="{{ old('captcha') }}" placeholder="Enter answer"
                           class="form-input w-40 @error('captcha') border-red-400 @enderror">
                    @error('captcha')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full bg-purple-900 hover:bg-purple-800 text-white font-bold py-3 px-6 rounded-xl transition">
                    Submit Now
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
