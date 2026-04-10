<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 12;
        $page    = (int) $request->get('page', 1);
        $total   = GalleryItem::where('is_active', true)->count();
        $items   = GalleryItem::where('is_active', true)
            ->orderBy('sort_order')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'html'      => view('partials.gallery-cards', ['items' => $items])->render(),
                'has_more'  => ($page * $perPage) < $total,
                'next_page' => $page + 1,
            ]);
        }

        $hasMore = $total > $perPage;
        return view('gallery', compact('items', 'hasMore'));
    }
}
