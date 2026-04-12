@extends('admin.layouts.app')
@section('title', 'Donate Settings')

@section('content')
@if(session('success'))
<div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
@endif

<form method="POST" action="{{ route('admin.donate.update') }}" enctype="multipart/form-data">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- QR Code --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">QR Code Image</h3>
            @php $qr = $settings['qr_image'] ?? null; @endphp
            @if($qr)
                <img src="{{ str_starts_with($qr, 'http') ? $qr : asset('storage/' . $qr) }}"
                     class="w-40 h-40 object-contain border rounded-lg p-2 mb-3" alt="QR Code">
                <p class="text-xs text-gray-400 mb-2">Upload new to replace</p>
            @endif
            <input type="file" name="qr_image" accept="image/*"
                   class="w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-purple-100 file:text-purple-700 file:font-semibold hover:file:bg-purple-200">
            <p class="text-xs text-gray-400 mt-1">Recommended: square PNG/JPG (max 1 MB)</p>
        </div>

        {{-- UPI Details --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">UPI Details</h3>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">UPI ID</label>
                <input type="text" name="upi_id" value="{{ $settings['upi_id'] ?? '' }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm font-mono"
                       placeholder="yourname@bankname">
            </div>
        </div>

        {{-- Tax Exemption Card Settings --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:col-span-2">
            <div class="flex items-center justify-between mb-4 pb-3 border-b border-gray-100">
                <h3 class="text-base font-bold text-gray-800">Tax Exemption Card</h3>
                <a href="{{ route('admin.tax-badges.index') }}"
                   class="inline-flex items-center gap-2 bg-orange-50 hover:bg-orange-100 text-orange-700 border border-orange-200 font-semibold text-xs px-4 py-2 rounded-lg transition">
                    <i class="fas fa-certificate"></i> Manage Badges (80G, 12A…)
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Card Title</label>
                    <input type="text" name="tax_title" value="{{ $settings['tax_title'] ?? '' }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm"
                           placeholder="Tax Exemption">
                    <p class="text-xs text-gray-400 mt-1">Leave blank to use default "Tax Exemption"</p>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Card Description</label>
                    <textarea name="tax_desc" rows="3"
                              class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm resize-y"
                              placeholder="All donations are eligible for tax exemption under Section 80G of the Income Tax Act.">{{ $settings['tax_desc'] ?? '' }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Description shown inside the orange tax card</p>
                </div>
            </div>
        </div>

        {{-- Bank Details --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">Bank Account Details</h3>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Account Holder Name</label>
                <input type="text" name="account_holder" value="{{ $settings['account_holder'] ?? '' }}"
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('account_holder') border-red-400 @enderror"
                       placeholder="e.g. Neem Karoli Baba Charitable Trust">
                @error('account_holder')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Bank Name *</label>
                <input type="text" name="bank_name" value="{{ $settings['bank_name'] ?? '' }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('bank_name') border-red-400 @enderror"
                       placeholder="State Bank of India">
                @error('bank_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Branch Name *</label>
                <input type="text" name="branch_name" value="{{ $settings['branch_name'] ?? '' }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm @error('branch_name') border-red-400 @enderror"
                       placeholder="Main Branch, City Name">
                @error('branch_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Account Number *</label>
                <input type="text" name="account_number" value="{{ $settings['account_number'] ?? '' }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm font-mono @error('account_number') border-red-400 @enderror"
                       placeholder="XXXXXXXXXXXX">
                @error('account_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">IFSC Code *</label>
                <input type="text" name="ifsc_code" value="{{ $settings['ifsc_code'] ?? '' }}" required
                       class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm font-mono @error('ifsc_code') border-red-400 @enderror"
                       placeholder="SBIN0001234">
                @error('ifsc_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        {{-- Donate Page Description --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-base font-bold text-gray-800 mb-4 pb-3 border-b border-gray-100">Donate Page Description</h3>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Description / Appeal Text</label>
                <textarea name="description" rows="8"
                          class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:outline-none focus:border-purple-400 text-sm resize-y"
                          placeholder="Your generous donation helps us serve the underprivileged and continue our mission...">{{ $settings['description'] ?? '' }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Shown on the donate page above the payment details</p>
            </div>
        </div>

    </div>

    <div class="mt-6">
        <button type="submit" class="bg-purple-900 hover:bg-purple-800 text-white font-bold py-2.5 px-8 rounded-lg transition text-sm">
            <i class="fas fa-save mr-1"></i> Save Donate Settings
        </button>
    </div>
</form>
@endsection
