@extends('admin.layouts.app')
@section('title', 'Site Settings')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8 max-w-2xl">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        @foreach([
            ['site_name', 'Site Name', 'text', 'Neem Karoli Baba Charitable Trust'],
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

        {{-- Header Photo --}}
        <div class="mb-6">
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                Header Photo
                <span class="text-gray-400 font-normal ml-1">(shown in site header — recommended square, min 200×200px)</span>
            </label>

            @if(!empty($settings['header_photo']))
            <div class="flex items-center gap-4 mb-3">
                <img src="{{ Storage::url($settings['header_photo']) }}"
                     alt="Current header photo"
                     class="w-20 h-20 rounded-lg object-cover border-4 border-yellow-400 shadow-md">
                <div class="text-xs text-gray-500">
                    <p class="font-semibold text-gray-700 mb-1">Current photo</p>
                    <p>Upload a new file below to replace it.</p>
                </div>
            </div>
            @endif

            <div class="flex items-center gap-3">
                <label for="header_photo_input"
                       class="cursor-pointer flex items-center gap-2 px-4 py-2.5 border-2 border-dashed border-purple-300 hover:border-purple-500 rounded-lg text-sm text-purple-700 font-medium transition bg-purple-50 hover:bg-purple-100">
                    <i class="fas fa-upload"></i>
                    <span id="photo_label">{{ !empty($settings['header_photo']) ? 'Change Photo' : 'Upload Photo' }}</span>
                </label>
                <input type="file" id="header_photo_input" name="header_photo" accept="image/*" class="hidden"
                       onchange="previewPhoto(this)">
                <span id="photo_filename" class="text-xs text-gray-500"></span>
            </div>

            {{-- Preview --}}
            <div id="photo_preview_wrap" class="mt-3 hidden">
                <p class="text-xs text-gray-500 mb-1">Preview:</p>
                <img id="photo_preview" src="" alt="Preview"
                     class="w-20 h-20 rounded-lg object-cover border-4 border-yellow-400 shadow-md">
            </div>

            @error('header_photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        {{-- Appeal Letter Image --}}
        <div class="mb-6 pt-4 border-t border-gray-100">
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Appeal Letter Image
                <span class="text-gray-400 font-normal ml-1">(shown on the Appeal page and home page bottom frame)</span>
            </label>
            @if(!empty($settings['appeal_image']))
            <div class="flex items-center gap-4 mb-3">
                <img src="{{ Storage::url($settings['appeal_image']) }}"
                     alt="Appeal Letter"
                     class="w-20 h-24 rounded-lg object-cover border-2 border-orange-300 shadow-sm">
                <div class="text-xs text-gray-500">
                    <p class="font-semibold text-gray-700 mb-1">Current appeal image</p>
                    <p>Upload a new file below to replace it.</p>
                </div>
            </div>
            @endif
            <input type="file" name="appeal_image" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 file:font-semibold hover:file:bg-orange-200">
            <p class="text-xs text-gray-400 mt-1">Recommended: portrait image (max 4 MB)</p>
            @error('appeal_image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-6 rounded-lg transition text-sm">
            <i class="fas fa-save mr-2"></i> Save Settings
        </button>
    </form>
</div>

<script>
function previewPhoto(input) {
    const wrap = document.getElementById('photo_preview_wrap');
    const preview = document.getElementById('photo_preview');
    const label = document.getElementById('photo_label');
    const filename = document.getElementById('photo_filename');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            wrap.classList.remove('hidden');
        };
        reader.readAsDataURL(input.files[0]);
        label.textContent = 'Change Photo';
        filename.textContent = input.files[0].name;
    }
}
</script>
@endsection
