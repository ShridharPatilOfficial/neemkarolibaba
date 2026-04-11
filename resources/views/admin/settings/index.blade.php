@extends('admin.layouts.app')
@section('title', 'Site Settings')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        @foreach([
            ['site_name', 'Site Name', 'text', '{{ $siteName }}'],
            ['reg_no',    'Registration No', 'text', 'IN-CH44392214903842V'],
            ['email',     'Email Address', 'email', 'support@neemkarolibaba.org.in'],
            ['phone',     'Phone Number', 'text', '+91 94644 33808'],
            ['whatsapp',  'WhatsApp Number (digits only, e.g. 919464433808)', 'text', '919464433808'],
            ['address',   'Office Address', 'text', 'Chandigarh - 160002'],
        ] as [$key, $label, $type, $placeholder])
        <div class="mb-5">
            <label class="block text-sm font-semibold text-gray-700 mb-1">{{ $label }}</label>
            <input type="{{ $type }}" name="{{ $key }}" value="{{ $settings[$key] ?? '' }}"
                   placeholder="{{ $placeholder }}"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error($key) border-red-400 @enderror">
            @error($key)<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        @endforeach

        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-1">Scrolling Ticker Text</label>
            <textarea name="ticker" rows="2"
                      class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('ticker') border-red-400 @enderror"
                      placeholder="Announcement text...">{{ $settings['ticker'] ?? '' }}</textarea>
            @error('ticker')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
            <i class="fas fa-save mr-2"></i> Save Settings
        </button>
    </form>
</div>
@endsection
