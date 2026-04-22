<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;

class InaugurationController extends Controller
{
    public function show()
    {
        $lockImage = SiteSetting::get('lock_image');
        $siteName  = SiteSetting::get('site_name', 'NKB Foundation');
        return view('inauguration', compact('lockImage', 'siteName'));
    }

    public function unlock(\Illuminate\Http\Request $request)
    {
        SiteSetting::set('site_locked', '0');
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['ok' => true, 'redirect' => route('home')]);
        }
        return redirect()->route('home');
    }

    public function unlocked()
    {
        $siteName = SiteSetting::get('site_name', 'NKB Foundation');
        return view('site-unlocked', compact('siteName'));
    }
}
