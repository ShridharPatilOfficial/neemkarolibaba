<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrgProfile;
use Illuminate\Http\Request;

class OrgProfileController extends Controller
{
    public function index()
    {
        $profiles = OrgProfile::orderBy('sort_order')->orderBy('sl_no')->get();
        return view('admin.org-profile.index', compact('profiles'));
    }

    public function create()
    {
        $nextSl = (OrgProfile::max('sl_no') ?? 0) + 1;
        return view('admin.org-profile.form', ['profile' => null, 'nextSl' => $nextSl]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sl_no'         => ['required', 'integer', 'min:1'],
            'document_name' => ['required', 'string', 'max:200'],
            'value'         => ['nullable', 'string', 'max:300'],
            'sort_order'    => ['integer', 'min:0'],
        ]);

        OrgProfile::create($data);
        return redirect()->route('admin.org-profile.index')->with('success', 'Record added.');
    }

    public function edit(OrgProfile $orgProfile)
    {
        return view('admin.org-profile.form', ['profile' => $orgProfile, 'nextSl' => $orgProfile->sl_no]);
    }

    public function update(Request $request, OrgProfile $orgProfile)
    {
        $data = $request->validate([
            'sl_no'         => ['required', 'integer', 'min:1'],
            'document_name' => ['required', 'string', 'max:200'],
            'value'         => ['nullable', 'string', 'max:300'],
            'sort_order'    => ['integer', 'min:0'],
        ]);

        $orgProfile->update($data);
        return redirect()->route('admin.org-profile.index')->with('success', 'Record updated.');
    }

    public function destroy(OrgProfile $orgProfile)
    {
        $orgProfile->delete();
        return back()->with('success', 'Record deleted.');
    }
}
