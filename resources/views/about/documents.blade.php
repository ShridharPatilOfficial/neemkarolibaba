@extends('layouts.app')
@section('title', 'Documents & Certificates - Neem Karoli Baba Foundation Worldwide')
@section('meta_desc', 'View official documents and certificates of Neem Karoli Baba Foundation Worldwide — 12A & 80G registration, trust deed, annual reports, and legal certifications of our registered NGO.')
@section('meta_keywords', 'NKB Foundation documents, NGO certificates India, 12A 80G certificate download, trust deed NKB, annual report NGO India, foundation legal documents')
@section('canonical', url('/about/documents'))
@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Documents & Certificates — Neem Karoli Baba Foundation Worldwide",
  "description": "Official documents, certificates and registrations of NKB Foundation including 12A and 80G.",
  "url": "{{ url('/about/documents') }}",
  "inLanguage": "en-IN",
  "isPartOf": { "@type": "WebSite", "url": "{{ url('/') }}" },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "About", "item": "{{ route('about') }}" },
      { "@type": "ListItem", "position": 3, "name": "Documents", "item": "{{ url('/about/documents') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Documents Gallery</h1>
        <p class="text-purple-200">Neem Karoli Baba Foundation Worldwide</p>
        <nav class="flex mt-3 text-sm">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <span class="mx-2 text-gray-400">/</span>
            <a href="{{ route('about') }}" class="text-orange-400 hover:underline">About Us</a>
            <span class="mx-2 text-gray-400">/</span>
            <span class="text-gray-300">Document Gallery</span>
        </nav>
    </div>
</div>

<section class="py-16 px-4">
    <div class="max-w-5xl mx-auto">
        @if($documents->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($documents as $doc)
            <a href="{{ route('documents.view', $doc->id) }}"
               target="{{ $doc->file_type === 'pdf' ? '_blank' : '_self' }}"
               class="card-hover flex items-center gap-3 bg-purple-900 hover:bg-purple-800 text-white font-semibold py-4 px-5 rounded-xl transition shadow-sm">
                <i class="fas {{ $doc->file_type === 'pdf' ? 'fa-file-pdf text-red-300' : 'fa-file-word text-blue-300' }} text-2xl flex-shrink-0"></i>
                <span class="text-sm">{{ $doc->name }}</span>
                <i class="fas fa-external-link-alt text-xs ml-auto text-purple-300"></i>
            </a>
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 py-12">No documents found.</p>
        @endif
    </div>
</section>
@endsection
