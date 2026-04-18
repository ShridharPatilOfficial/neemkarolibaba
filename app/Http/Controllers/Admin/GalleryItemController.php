<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryItemController extends Controller
{
    use ManagesSortOrder;

    public function index(Request $request)
    {
        $items = GalleryItem::orderBy('sort_order')->paginate(20);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        $nextOrder = $this->nextSortOrder(GalleryItem::class);
        return view('admin.gallery.form', ['item' => null, 'nextOrder' => $nextOrder]);
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

        $nextOrder = $this->nextSortOrder(GalleryItem::class);
        $imageUrl  = null;
        if ($request->hasFile('image')) {
            $imageUrl = $request->file('image')->store('gallery', 'public');
        }

        $item = GalleryItem::create([
            'headline'    => $request->headline,
            'image_url'   => $imageUrl,
            'youtube_url' => $request->youtube_url,
            'type'        => $request->type,
            'sort_order'  => $request->input('sort_order', 0),
            'is_active'   => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(GalleryItem::class, $item->id, $item->sort_order, $nextOrder);

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

        $oldOrder = $gallery->sort_order;
        $imageUrl = $gallery->image_url;

        if ($request->hasFile('image')) {
            if ($gallery->image_url) Storage::disk('public')->delete($gallery->image_url);
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

        $this->swapSortOrderIfConflict(GalleryItem::class, $gallery->id, $gallery->sort_order, $oldOrder);

        return redirect()->route('admin.gallery.index')->with('success', 'Gallery item updated.');
    }

    public function destroy(GalleryItem $gallery)
    {
        if ($gallery->image_url) Storage::disk('public')->delete($gallery->image_url);
        $gallery->delete();
        return back()->with('success', 'Gallery item deleted.');
    }
}
