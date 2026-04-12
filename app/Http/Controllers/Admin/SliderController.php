<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.form', ['slider' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image'       => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'caption'     => ['nullable', 'string', 'max:200'],
            'sort_order'  => ['integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $path = $request->file('image')->store('sliders', 'public');

        Slider::create([
            'image_url'  => $path,
            'caption'    => $data['caption'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider added successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate([
            'image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'caption'    => ['nullable', 'string', 'max:200'],
            'sort_order' => ['integer', 'min:0'],
            'is_active'  => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($slider->image_url);
            $data['image_url'] = $request->file('image')->store('sliders', 'public');
        }

        $slider->update([
            'image_url'  => $data['image_url'] ?? $slider->image_url,
            'caption'    => $data['caption'] ?? null,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        Storage::disk('public')->delete($slider->image_url);
        $slider->delete();
        return back()->with('success', 'Slider deleted.');
    }
}
