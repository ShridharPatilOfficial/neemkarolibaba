<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrustObjective;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrustObjectiveController extends Controller
{
    public function index()
    {
        $objectives = TrustObjective::orderBy('sort_order')->get();
        return view('admin.trust-objectives.index', compact('objectives'));
    }

    public function create()
    {
        $objective = null;
        return view('admin.trust-objectives.form', compact('objective'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order'  => ['nullable', 'integer'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('trust-objectives', 'public');
        } else {
            $data['image'] = null;
        }

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        TrustObjective::create($data);

        return redirect()->route('admin.trust-objectives.index')->with('success', 'Objective added successfully.');
    }

    public function edit(TrustObjective $trustObjective)
    {
        $objective = $trustObjective;
        return view('admin.trust-objectives.form', compact('objective'));
    }

    public function update(Request $request, TrustObjective $trustObjective)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sort_order'  => ['nullable', 'integer'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($trustObjective->image) {
                Storage::disk('public')->delete($trustObjective->image);
            }
            $data['image'] = $request->file('image')->store('trust-objectives', 'public');
        } else {
            $data['image'] = $trustObjective->image;
        }

        // Remove image if "remove image" checkbox checked
        if ($request->boolean('remove_image')) {
            if ($trustObjective->image) {
                Storage::disk('public')->delete($trustObjective->image);
            }
            $data['image'] = null;
        }

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $trustObjective->update($data);

        return redirect()->route('admin.trust-objectives.index')->with('success', 'Objective updated successfully.');
    }

    public function destroy(TrustObjective $trustObjective)
    {
        if ($trustObjective->image) {
            Storage::disk('public')->delete($trustObjective->image);
        }
        $trustObjective->delete();
        return back()->with('success', 'Objective deleted.');
    }
}
