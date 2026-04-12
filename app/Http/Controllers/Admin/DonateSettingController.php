<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DonateSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonateSettingController extends Controller
{
    private array $fields = [
        'description', 'account_holder', 'bank_name', 'branch_name', 'account_number', 'ifsc_code', 'upi_id',
        'tax_title', 'tax_desc',
    ];

    public function index()
    {
        $settings = [];
        foreach ($this->fields as $key) {
            $settings[$key] = DonateSetting::get($key);
        }
        $settings['qr_image'] = DonateSetting::get('qr_image');
        return view('admin.donate.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'description'    => ['nullable', 'string', 'max:1000'],
            'account_holder' => ['nullable', 'string', 'max:150'],
            'bank_name'      => ['required', 'string', 'max:100'],
            'branch_name'    => ['required', 'string', 'max:100'],
            'account_number' => ['required', 'string', 'max:30'],
            'ifsc_code'      => ['required', 'string', 'max:20'],
            'upi_id'         => ['nullable', 'string', 'max:50'],
            'tax_title'      => ['nullable', 'string', 'max:100'],
            'tax_desc'       => ['nullable', 'string', 'max:500'],
            'qr_image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
        ]);

        foreach ($this->fields as $key) {
            DonateSetting::set($key, (string) ($request->input($key) ?? ''));
        }

        if ($request->hasFile('qr_image')) {
            $existing = DonateSetting::get('qr_image');
            if ($existing) {
                Storage::disk('public')->delete($existing);
            }
            $path = $request->file('qr_image')->store('donate', 'public');
            DonateSetting::set('qr_image', $path, 'image');
        }

        return back()->with('success', 'Donation settings updated.');
    }
}
