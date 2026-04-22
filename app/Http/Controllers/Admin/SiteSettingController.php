<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function index()
    {
        $keys = ['site_name', 'reg_no', 'email', 'phone', 'whatsapp', 'address', 'ticker', 'header_photo', 'appeal_image', 'appeal_image_mr', 'facebook', 'instagram', 'youtube', 'twitter'];
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = SiteSetting::get($key);
        }
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name'    => ['required', 'string', 'max:200'],
            'reg_no'       => ['required', 'string', 'max:100'],
            'email'        => ['required', 'email', 'max:100'],
            'phone'        => ['required', 'string', 'max:20'],
            'whatsapp'     => ['required', 'string', 'max:20'],
            'address'      => ['required', 'string', 'max:300'],
            'ticker'        => ['nullable', 'string', 'max:500'],
            'facebook'      => ['nullable', 'url', 'max:300'],
            'instagram'     => ['nullable', 'url', 'max:300'],
            'youtube'       => ['nullable', 'url', 'max:300'],
            'twitter'       => ['nullable', 'url', 'max:300'],
            'header_photo'  => ['nullable', 'image', 'max:2048'],
            'appeal_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'appeal_image_mr' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        // Handle file uploads separately
        unset($data['header_photo']);
        unset($data['appeal_image']);
        unset($data['appeal_image_mr']);

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value ?? '');
        }

        if ($request->hasFile('header_photo')) {
            $old = SiteSetting::get('header_photo');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('header_photo')->store('settings', 'public');
            SiteSetting::set('header_photo', $path);
        }

        if ($request->hasFile('appeal_image')) {
            $old = SiteSetting::get('appeal_image');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('appeal_image')->store('settings', 'public');
            SiteSetting::set('appeal_image', $path);
        }

        if ($request->hasFile('appeal_image_mr')) {
            $old = SiteSetting::get('appeal_image_mr');
            if ($old && Storage::disk('public')->exists($old)) {
                Storage::disk('public')->delete($old);
            }
            $path = $request->file('appeal_image_mr')->store('settings', 'public');
            SiteSetting::set('appeal_image_mr', $path);
        }

        return back()->with('success', 'Site settings updated successfully.');
    }
}
