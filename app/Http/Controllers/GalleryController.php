<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $perPage = in_array((int) $request->input('per_page'), [25, 50, 100]) ? (int) $request->input('per_page') : 25;
        $page    = (int) $request->get('page', 1);
        $total   = GalleryItem::where('is_active', true)->count();
        $items   = GalleryItem::where('is_active', true)
            ->orderBy('sort_order')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        if ($request->ajax()) {
            $startIndex = ($page - 1) * $perPage;
            return response()->json([
                'html'      => view('partials.gallery-cards', ['items' => $items, 'startIndex' => $startIndex])->render(),
                'items'     => $items->map(fn($i) => [
                    'id'          => $i->id,
                    'headline'    => $i->headline,
                    'type'        => $i->type,
                    'image_url'   => $i->image_url && !str_starts_with($i->image_url,'http') ? asset('storage/'.$i->image_url) : $i->image_url,
                    'youtube_url' => $i->youtube_url,
                    'yt_id'       => preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $i->youtube_url ?? '', $m) ? $m[1] : null,
                ]),
                'has_more'  => ($page * $perPage) < $total,
                'next_page' => $page + 1,
            ]);
        }

        $hasMore = $total > $perPage;
        return view('gallery', compact('items', 'hasMore', 'perPage'));
    }
}
