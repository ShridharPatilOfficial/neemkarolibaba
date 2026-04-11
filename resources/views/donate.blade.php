@extends('layouts.app')
@section('title', 'Donate — Support NKB Foundation Worldwide (12A & 80G Registered)')
@section('meta_desc', 'Donate to Neem Karoli Baba Foundation Worldwide — a 12A & 80G registered NGO. Your contribution funds food, education, healthcare and spiritual seva for the underprivileged in India. Tax benefits available.')
@section('meta_keywords', 'donate NKB Foundation, donation 80G tax benefit India, NGO donation India, Neem Karoli Baba donation, online donate NGO, charity donation India, 12A 80G registered NGO')
@section('canonical', route('donate'))
@push('schema')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "DonateAction",
  "name": "Donate to NKB Foundation",
  "description": "Support Neem Karoli Baba Foundation Worldwide — 12A & 80G registered NGO. Tax-deductible donations for charitable work in India.",
  "url": "{{ route('donate') }}",
  "recipient": {
    "@type": "NGO",
    "name": "Neem Karoli Baba Foundation Worldwide",
    "url": "{{ url('/') }}"
  }
}
</script>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebPage",
  "name": "Donate — Neem Karoli Baba Foundation Worldwide",
  "url": "{{ route('donate') }}",
  "inLanguage": "en-IN",
  "isPartOf": { "@type": "WebSite", "url": "{{ url('/') }}" },
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      { "@type": "ListItem", "position": 1, "name": "Home", "item": "{{ url('/') }}" },
      { "@type": "ListItem", "position": 2, "name": "Donate", "item": "{{ route('donate') }}" }
    ]
  }
}
</script>
@endpush

@section('content')

{{-- Page Banner --}}
<div class="page-banner py-20 px-4 text-white relative">
    <div class="relative z-10 max-w-4xl mx-auto">
        <span class="section-tag" style="color:#f97316">Support Us</span>
        <h1 class="text-4xl md:text-5xl font-black mt-1 mb-2">Donate Us</h1>
        <p class="text-purple-200 text-sm">Every contribution makes a difference</p>
        <nav class="flex mt-3 text-sm items-center gap-1">
            <a href="{{ route('home') }}" class="text-orange-400 hover:underline">Home</a>
            <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
            <span class="text-gray-300">Donate Us</span>
        </nav>
    </div>
</div>

{{-- Hero CTA Strip --}}
<div class="donate-ribbon py-10 px-4">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
        <div>
            <h2 class="text-2xl md:text-3xl font-black text-white mb-1">Be the Change — Give Today</h2>
            <p class="text-orange-100 text-sm max-w-md">
                {{ $settings['description'] ? Str::limit($settings['description'], 120) : 'Your generosity directly funds education, healthcare, and community feeding programmes.' }}
            </p>
        </div>
        <a href="#payment-section"
           class="donate-btn flex-shrink-0 inline-flex items-center gap-3 font-black py-4 px-10 rounded-2xl shadow-2xl text-base scroll-to-payment">
            <i class="fas fa-arrow-down btn-heart text-xl"></i>
            View Payment Details
        </a>
    </div>
</div>

<section id="payment-section" class="py-16 px-4 bg-gray-50">
    <div class="max-w-6xl mx-auto">

        {{-- Description block --}}
        @if($settings['description'])
        <div class="bg-white rounded-2xl p-6 mb-10 border border-gray-100 shadow-sm max-w-3xl mx-auto text-center">
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-heart text-orange-600 text-lg"></i>
            </div>
            <p class="text-gray-600 leading-relaxed text-sm">{{ $settings['description'] }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ── BANK DETAILS ─────────────────────────────── --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 h-full">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-blue-700 to-blue-900 px-6 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-building-columns text-white text-base"></i>
                        </div>
                        <div>
                            <p class="text-white font-black text-base leading-tight">Bank Transfer</p>
                            <p class="text-blue-200 text-xs">NEFT / RTGS / IMPS</p>
                        </div>
                    </div>

                    {{-- Details --}}
                    <div class="p-4 space-y-1">
                        @foreach([
                            ['fa-university',       'blue',   'Bank Name',       $settings['bank_name']       ?? '—'],
                            ['fa-map-marker-alt',   'indigo', 'Branch',          $settings['branch_name']     ?? '—'],
                            ['fa-hashtag',          'purple', 'Account Number',  $settings['account_number']  ?? '—'],
                            ['fa-code',             'violet', 'IFSC Code',       $settings['ifsc_code']       ?? '—'],
                        ] as [$icon, $color, $label, $value])
                        <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                            <span class="w-8 h-8 rounded-lg bg-{{ $color }}-100 flex items-center justify-center flex-shrink-0 mt-0.5 group-hover:bg-{{ $color }}-200 transition">
                                <i class="fas {{ $icon }} text-{{ $color }}-600 text-xs"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-gray-400 text-xs font-semibold uppercase tracking-wider leading-none mb-1">{{ $label }}</p>
                                <p class="text-gray-800 font-bold text-sm break-all">{{ $value }}</p>
                            </div>
                            {{-- Copy button --}}
                            <button onclick="copyText('{{ $value }}', this)"
                                    class="ml-auto flex-shrink-0 w-7 h-7 rounded-lg bg-gray-100 hover:bg-blue-100 flex items-center justify-center transition opacity-0 group-hover:opacity-100"
                                    title="Copy">
                                <i class="fas fa-copy text-gray-400 hover:text-blue-600 text-xs"></i>
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- ── UPI DETAILS ──────────────────────────────── --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 h-full">
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-purple-600 to-violet-800 px-6 py-4 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-mobile-screen-button text-white text-base"></i>
                        </div>
                        <div>
                            <p class="text-white font-black text-base leading-tight">UPI Payment</p>
                            <p class="text-purple-200 text-xs">PhonePe / GPay / Paytm</p>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col items-center justify-center text-center h-[calc(100%-72px)]">
                        {{-- QR Code --}}
                        @if($settings['qr_image'])
                        <div class="mb-4 p-3 bg-white border-2 border-purple-100 rounded-2xl shadow-md inline-block">
                            <img src="{{ str_starts_with($settings['qr_image'], 'http') ? $settings['qr_image'] : asset('storage/' . $settings['qr_image']) }}"
                                 alt="UPI QR Code" class="w-44 h-44 object-contain">
                        </div>
                        <p class="text-gray-400 text-xs mb-4">Scan with any UPI app</p>
                        @else
                        <div class="mb-4 w-44 h-44 rounded-2xl border-2 border-dashed border-purple-200 flex flex-col items-center justify-center">
                            <i class="fas fa-qrcode text-purple-200 text-5xl mb-2"></i>
                            <p class="text-gray-300 text-xs">QR Code</p>
                        </div>
                        <p class="text-gray-400 text-xs mb-4">QR will appear once admin adds it</p>
                        @endif

                        {{-- UPI ID pill --}}
                        @if($settings['upi_id'])
                        <div class="w-full bg-gradient-to-r from-purple-50 to-violet-50 border border-purple-200 rounded-xl px-4 py-3 flex items-center justify-between gap-2">
                            <div class="text-left">
                                <p class="text-purple-400 text-[10px] font-bold uppercase tracking-wider">UPI ID</p>
                                <p class="text-purple-800 font-black text-sm font-mono">{{ $settings['upi_id'] }}</p>
                            </div>
                            <button onclick="copyText('{{ $settings['upi_id'] }}', this)"
                                    class="w-8 h-8 rounded-lg bg-purple-100 hover:bg-purple-200 flex items-center justify-center flex-shrink-0 transition"
                                    title="Copy UPI ID">
                                <i class="fas fa-copy text-purple-600 text-xs"></i>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ── TAX / INFO CARD ──────────────────────────── --}}
            <div class="lg:col-span-1 flex flex-col gap-6">

                {{-- Tax Exemption Card --}}
                <div class="bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl p-6 text-white shadow-lg">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center mb-4">
                        <i class="fas fa-certificate text-white text-xl"></i>
                    </div>
                    <h3 class="font-black text-lg mb-2">Tax Exemption</h3>
                    <p class="text-orange-100 text-sm leading-relaxed">
                        {{ $settings['tax_note'] ?: 'All donations are eligible for tax exemption under Section 80G of the Income Tax Act. Certificate provided on request.' }}
                    </p>
                    <div class="mt-4 flex gap-2">
                        <span class="bg-white/20 border border-white/30 text-white text-xs font-bold px-3 py-1 rounded-full">80G</span>
                        <span class="bg-white/20 border border-white/30 text-white text-xs font-bold px-3 py-1 rounded-full">12A</span>
                        <span class="bg-white/20 border border-white/30 text-white text-xs font-bold px-3 py-1 rounded-full">CSR</span>
                    </div>
                </div>

                {{-- How to Donate steps --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm flex-1">
                    <h3 class="font-black text-gray-900 mb-4 flex items-center gap-2">
                        <i class="fas fa-list-check text-orange-500"></i> How to Donate
                    </h3>
                    <ol class="space-y-3">
                        @foreach([
                            ['Open any UPI app (PhonePe / GPay / Paytm)', 'fa-mobile-screen-button', 'purple'],
                            ['Scan the QR code or enter UPI ID', 'fa-qrcode', 'blue'],
                            ['Enter donation amount & confirm', 'fa-indian-rupee-sign', 'green'],
                            ['Send screenshot to us on WhatsApp', 'fab fa-whatsapp', 'emerald'],
                        ] as $i => [$step, $icon, $col])
                        <li class="flex items-start gap-3">
                            <span class="w-6 h-6 rounded-full bg-{{ $col }}-100 text-{{ $col }}-700 text-xs font-black flex items-center justify-center flex-shrink-0 mt-0.5">{{ $i+1 }}</span>
                            <span class="text-gray-600 text-sm leading-snug">{{ $step }}</span>
                        </li>
                        @endforeach
                    </ol>
                    {{-- WhatsApp shortcut --}}
                    <a href="https://wa.me/{{ \App\Models\SiteSetting::get('whatsapp','919876543210') }}"
                       target="_blank"
                       class="mt-5 w-full inline-flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold py-2.5 rounded-xl transition text-sm">
                        <i class="fab fa-whatsapp text-base"></i> Share on WhatsApp
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Bottom banner --}}
<div class="bg-purple-950 text-white py-10 px-4">
    <div class="max-w-4xl mx-auto text-center">
        <div class="flex flex-wrap justify-center gap-8 text-sm text-purple-300">
            <div class="flex items-center gap-2">
                <i class="fas fa-shield-halved text-orange-400"></i>
                <span>100% Secure Payments</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-receipt text-orange-400"></i>
                <span>Receipt Provided</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-certificate text-orange-400"></i>
                <span>80G Tax Exemption</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fas fa-hand-holding-heart text-orange-400"></i>
                <span>Funds Used Transparently</span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Smooth scroll to #payment-section on load if hash is present
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.hash === '#payment-section') {
        const target = document.getElementById('payment-section');
        if (target) {
            setTimeout(() => {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 120);
        }
    }
});

function copyText(text, btn) {
    navigator.clipboard.writeText(text).then(() => {
        const icon = btn.querySelector('i');
        icon.className = 'fas fa-check text-green-600 text-xs';
        btn.classList.add('bg-green-100');
        setTimeout(() => {
            icon.className = 'fas fa-copy text-gray-400 hover:text-blue-600 text-xs';
            btn.classList.remove('bg-green-100');
        }, 1800);
    });
}
</script>
@endpush
