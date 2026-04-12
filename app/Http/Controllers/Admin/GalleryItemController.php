<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    public function index(Request $request)
    {
        $items = GalleryItem::orderBy('sort_order')->paginate(20);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'headline'    => ['nullable', 'string', 'max:150'],
            'type'        => ['required', 'in:image,video,both'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'youtube_url' => ['nullable', 'url', 'max:300'],
            'sort_order'  => ['integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $imageUrl = null;
        if ($request->hasFile('image')) {
            $imageUrl = $request->file('image')->store('gallery', 'public');
        }

        GalleryItem::create([
            'headline'    => $request->headline,
            'image_url'   => $imageUrl,
            'youtube_url' => $request->youtube_url,
            'type'        => $request->type,
            'sort_order'  => $request->input('sort_order', 0),
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item added.');
    }

    public function edit(GalleryItem $gallery)
    {
        return view('admin.gallery.form', ['item' => $gallery]);
    }

    public function update(Request $request, GalleryItem $gallery)
    {
        $request->validate([
            'headline'    => ['nullable', 'string', 'max:150'],
            'type'        => ['required', 'in:image,video,both'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'youtube_url' => ['nullable', 'url', 'max:300'],
            'sort_order'  => ['integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $imageUrl = $gallery->image_url;
        if ($request->hasFile('image')) {
            if ($gallery->image_url) {
                Storage::disk('public')->delete($gallery->image_url);
            }
            $imageUrl = $request->file('image')->store('gallery', 'public');
        }

        $gallery->update([
            'headline'    => $request->headline,
            'image_url'   => $imageUrl,
            'youtube_url' => $request->youtube_url,
            'type'        => $request->type,
            'sort_order'  => $request->input('sort_order', 0),
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $gallery)
    {
        if ($gallery->image_url) {
            Storage::disk('public')->delete($gallery->image_url);
        }
        $gallery->delete();
        return back()->with('success', 'Gallery item deleted.');
    }
}
