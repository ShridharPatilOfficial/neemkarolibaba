@extends('layouts.app')
@section('title', 'Documents & Certificates — '.$siteName)
@section('meta_desc', 'View official documents and certificates of '.$siteName.' — 12A & 80G registration, trust deed, annual reports, and legal certifications of our registered NGO.')
@section('meta_keywords', 'NKB Foundation documents, NGO certificates India, 12A 80G certificate, trust deed NKB, annual report NGO India, foundation legal documents')
@section('canonical', route('about.documents'))
@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Documents & Certificates — {{ $siteName }}",
  "url": "{{ route('about.documents') }}",
  "inLanguage": "en-IN",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      { "@@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@@type": "ListItem", "position": 2, "name": "About", "item": "{{ route('about') }}" },
      { "@@type": "ListItem", "position": 3, "name": "Documents", "item": "{{ route('about.documents') }}" }
    ]
  }
}
</script>
@endpush

@section('content')
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-2">Documents Gallery</h1>
        <p class="text-purple-200">{{ $siteName }}</p>
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
            @if($doc->file_type === 'pdf')
            <button onclick="viewDoc('{{ route('documents.view', $doc->id) }}','{{ addslashes($doc->name) }}')"
                    class="card-hover flex items-center gap-3 bg-purple-900 hover:bg-purple-800 text-white font-semibold py-4 px-5 rounded-xl transition shadow-sm w-full text-left">
                <i class="fas fa-file-pdf text-red-300 text-2xl flex-shrink-0"></i>
                <span class="text-sm">{{ $doc->name }}</span>
                <i class="fas fa-eye text-xs ml-auto text-purple-300"></i>
            </button>
            @else
            <a href="{{ route('documents.view', $doc->id) }}"
               class="card-hover flex items-center gap-3 bg-purple-900 hover:bg-purple-800 text-white font-semibold py-4 px-5 rounded-xl transition shadow-sm">
                <i class="fas fa-file-word text-blue-300 text-2xl flex-shrink-0"></i>
                <span class="text-sm">{{ $doc->name }}</span>
                <i class="fas fa-download text-xs ml-auto text-purple-300"></i>
            </a>
            @endif
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500 py-12">No documents found.</p>
        @endif
    </div>
</section>

{{-- PDF Viewer Modal --}}
<div id="pubDocModal" class="fixed inset-0 z-[99999] hidden items-center justify-center"
     style="background:rgba(0,0,0,.88);backdrop-filter:blur(5px);"
     onclick="if(event.target===this)closeDocModal()">
    <div class="w-full max-w-4xl mx-4 flex flex-col" style="height:90vh;" onclick="event.stopPropagation()">
        <div class="flex items-center justify-between mb-3">
            <p id="pubDocTitle" class="text-white font-bold text-sm truncate"></p>
            <button onclick="closeDocModal()"
                    class="w-9 h-9 rounded-full bg-white/10 hover:bg-orange-500 text-white flex items-center justify-center transition flex-shrink-0 ml-3">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <iframe id="pubDocFrame" src="" class="w-full flex-1 rounded-xl border-0 bg-white"></iframe>
    </div>
</div>

@endsection

@push('scripts')
<script>
function viewDoc(url, title) {
    document.getElementById('pubDocFrame').src = url;
    document.getElementById('pubDocTitle').textContent = title || 'Document';
    var m = document.getElementById('pubDocModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function closeDocModal() {
    document.getElementById('pubDocFrame').src = '';
    var m = document.getElementById('pubDocModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', function(e){ if(e.key==='Escape') closeDocModal(); });
document.body.appendChild(document.getElementById('pubDocModal'));
</script>
@endpush
