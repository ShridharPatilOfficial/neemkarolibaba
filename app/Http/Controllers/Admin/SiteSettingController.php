<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function index()
    {
        $keys = ['site_name', 'reg_no', 'email', 'phone', 'whatsapp', 'address', 'ticker'];
        $settings = [];
        foreach ($keys as $key) {
            $settings[$key] = SiteSetting::get($key);
        }
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:200'],
            'reg_no'    => ['required', 'string', 'max:100'],
            'email'     => ['required', 'email', 'max:100'],
            'phone'     => ['required', 'string', 'max:20'],
            'whatsapp'  => ['required', 'string', 'max:20'],
            'address'   => ['required', 'string', 'max:300'],
            'ticker'    => ['nullable', 'string', 'max:500'],
        ]);

        foreach ($data as $key => $value) {
            SiteSetting::set($key, $value ?? '');
        }

        return back()->with('success', 'Site settings updated successfully.');
    }
}
