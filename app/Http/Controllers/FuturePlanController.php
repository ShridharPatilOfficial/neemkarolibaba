<?php

namespace App\Http\Controllers;

use App\Models\FuturePlan;
use Illuminate\Http\Request;

class FuturePlanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 10;
        $page    = (int) $request->get('page', 1);
        $total   = FuturePlan::where('is_active', true)->count();
        $items   = FuturePlan::where('is_active', true)
            ->orderBy('sort_order')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        if ($request->ajax()) {
            return response()->json([
                'html'      => view('partials.content-cards', ['items' => $items])->render(),
                'has_more'  => ($page * $perPage) < $total,
                'next_page' => $page + 1,
            ]);
        }

        $hasMore = $total > $perPage;
        return view('future-plan', compact('items', 'hasMore'));
    }
}
