<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PresidentMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PresidentMessageController extends Controller
{
    public function index()
    {
        $messages = PresidentMessage::all();
        return view('admin.president.index', compact('messages'));
    }

    public function create()
    {
        return view('admin.president.form', ['msg' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'president_name'  => ['required', 'string', 'max:100'],
            'president_title' => ['required', 'string', 'max:150'],
            'message'         => ['required', 'string'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'signature'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:512'],
            'is_active'       => ['boolean'],
        ]);

        $photoUrl = null;
        if ($request->hasFile('photo')) {
            $photoUrl = $request->file('photo')->store('president', 'public');
        }

        $sigUrl = null;
        if ($request->hasFile('signature')) {
            $sigUrl = $request->file('signature')->store('signatures', 'public');
        }

        PresidentMessage::create([
            'president_name'  => $request->president_name,
            'president_title' => $request->president_title,
            'photo_url'       => $photoUrl,
            'message'         => $request->message,
            'signature_url'   => $sigUrl,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.president.index')->with('success', 'Message added.');
    }

    public function edit(PresidentMessage $president)
    {
        return view('admin.president.form', ['msg' => $president]);
    }

    public function update(Request $request, PresidentMessage $president)
    {
        $request->validate([
            'president_name'  => ['required', 'string', 'max:100'],
            'president_title' => ['required', 'string', 'max:150'],
            'message'         => ['required', 'string'],
            'photo'           => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'signature'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:512'],
            'is_active'       => ['boolean'],
        ]);

        $photoUrl = $president->photo_url;
        if ($request->hasFile('photo')) {
            if ($president->photo_url) {
                Storage::disk('public')->delete($president->photo_url);
            }
            $photoUrl = $request->file('photo')->store('president', 'public');
        }

        $sigUrl = $president->signature_url;
        if ($request->hasFile('signature')) {
            if ($president->signature_url) {
                Storage::disk('public')->delete($president->signature_url);
            }
            $sigUrl = $request->file('signature')->store('signatures', 'public');
        }

        $president->update([
            'president_name'  => $request->president_name,
            'president_title' => $request->president_title,
            'photo_url'       => $photoUrl,
            'message'         => $request->message,
            'signature_url'   => $sigUrl,
            'is_active'       => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.president.index')->with('success', 'Message updated.');
    }

    public function destroy(PresidentMessage $president)
    {
        if ($president->photo_url) {
            Storage::disk('public')->delete($president->photo_url);
        }
        if ($president->signature_url) {
            Storage::disk('public')->delete($president->signature_url);
        }
        $president->delete();
        return back()->with('success', 'Message deleted.');
    }
}
