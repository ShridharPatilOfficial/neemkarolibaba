@extends('layouts.app')
@section('title', 'Organisation Profile — Neem Karoli Baba Charitable Trust')
@section('meta_desc', 'Organisation profile of Neem Karoli Baba Charitable Trust — legal details, registration numbers, 12A & 80G certifications, and trust deed information of our registered NGO in India.')
@section('meta_keywords', 'NKB Foundation organisation profile, NGO registration India, 12A 80G certificate, trust deed India, NKB Foundation legal, registered NGO details, foundation profile')
@section('canonical', route('about.org-profile'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Organisation Profile — Neem Karoli Baba Charitable Trust",
  "url": "{{ route('about.org-profile') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "About", "item": "{{ route('about') }}" },
      { "@@type": "ListItem", "position": 3, "name": "Organisation Profile", "item": "{{ route('about.org-profile') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Organisation Profile</h1>
        <p class="text-purple-200">Neem Karoli Baba Charitable Trust</p>
        <nav class="flex mt-3 text-sm">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('about') }}" class="text-orange-400 hover:underline">About Us</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">Organisation Profile</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4">
    <div class="max-w-4xl mx-auto">
        @if($profiles->count())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-purple-900 text-white">
                        <th class="py-3 px-4 text-left w-16">Sl No</th>
                        <th class="py-3 px-4 text-left">Document Name</th>
                        <th class="py-3 px-4 text-left">Number / Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                    <tr class="border-b border-gray-100 {{ $loop->even ? 'bg-gray-50' : 'bg-white' }} hover:bg-orange-50 transition">
                        <td class="py-3 px-4 text-orange-600 font-bold">{{ $profile->sl_no }}</td>
                        <td class="py-3 px-4 text-orange-600 font-medium">{{ $profile->document_name }}</td>
                        <td class="py-3 px-4 text-gray-700">
                            @if(filter_var($profile->value, FILTER_VALIDATE_URL))
                                <a href="{{ $profile->value }}" target="_blank" class="text-blue-600 hover:underline">{{ $profile->value }}</a>
                            @elseif(filter_var($profile->value, FILTER_VALIDATE_EMAIL))
                                <a href="mailto:{{ $profile->value }}" class="text-blue-600 hover:underline">{{ $profile->value }}</a>
                            @else
                                {{ $profile->value ?? '-' }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <p class="text-center text-gray-500 py-12">Organisation profile information coming soon.</p>
        @endif
    </div>
</section>
@endsection
