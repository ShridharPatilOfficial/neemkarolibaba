@extends('layouts.app')
@section('title', 'Contact Us - Neem Karoli Baba Foundation Worldwide')
@section('meta_desc', 'Get in touch with Neem Karoli Baba Foundation Worldwide. Contact us for donations, volunteering, partnerships, or any queries about our charitable work in India.')
@section('meta_keywords', 'contact NKB Foundation, Neem Karoli Baba Foundation contact, NGO contact India, donate contact, volunteer contact NKB, NKB Foundation address')
@section('canonical', route('contact'))
@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "ContactPage",
  "name": "Contact Us — Neem Karoli Baba Foundation Worldwide",
  "description": "Contact NKB Foundation for donations, volunteering, or partnership enquiries.",
  "url": "{{ route('contact') }}",
  "inLanguage": "en-IN",
  "isPartOf": { "@type": "WebSite", "url": "{{ url('/') }}" },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "Contact", "item": "{{ route('contact') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Contact Us</h1>
        <p class="text-purple-200">Neem Karoli Baba Foundation Worldwide</p>
        <nav class="flex mt-3 text-sm">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">Contact Us</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4">
    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Left: Contact Info -->
        <div>
            <h2 class="text-3xl font-extrabold text-orange-600 mb-6">Get In Touch</h2>
            <p class="text-gray-500 mb-8 text-sm leading-relaxed">
                Reach out to us for more information on how you can get involved or support our initiatives. We look forward to connecting with you!
            </p>

            <div class="space-y-5">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-map-marker-alt text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Regd. Office Address</h4>
                        <p class="text-gray-600 text-sm">{{ $settings['address'] }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-phone text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Contact Number</h4>
                        <a href="tel:{{ $settings['phone'] }}" class="text-gray-600 text-sm hover:text-orange-600">{{ $settings['phone'] }}</a>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-orange-500 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-envelope text-white"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Mail Id</h4>
                        <a href="mailto:{{ $settings['email'] }}" class="text-blue-600 text-sm hover:underline">{{ $settings['email'] }}</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
            <h3 class="text-xl font-bold text-orange-600 mb-6">Quick Contact</h3>

            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center gap-3">
                <i class="fas fa-check-circle text-green-500 text-xl"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('contact.store') }}" novalidate>
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" placeholder="First Name"
                               class="form-input @error('first_name') border-red-400 @enderror">
                        @error('first_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name"
                               class="form-input @error('last_name') border-red-400 @enderror">
                        @error('last_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address"
                               class="form-input @error('email') border-red-400 @enderror">
                        @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="Your Phone" maxlength="10"
                               class="form-input @error('phone') border-red-400 @enderror">
                        @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="mb-4">
                    <textarea name="message" rows="4" placeholder="Message"
                              class="form-input resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                    @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="mb-5 flex items-center gap-3">
                    <span class="text-gray-700 font-semibold text-sm">{{ $num1 }} + {{ $num2 }} =</span>
                    <input type="number" name="captcha" value="{{ old('captcha') }}" placeholder="?"
                           class="form-input w-24 @error('captcha') border-red-400 @enderror">
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
