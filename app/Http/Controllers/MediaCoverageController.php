<?php
namespace App\Http\Controllers;
use App\Models\MediaCoverage;
use Illuminate\Http\Request;

class MediaCoverageController extends Controller {
    public function index(Request $request) {
        $perPage   = 9;
        $page      = (int) $request->get('page', 1);
        $category  = $request->get('category');
        $query     = MediaCoverage::where('is_active', true)->orderByDesc('published_date')->orderBy('sort_order');
        if ($category) $query->where('category', $category);
        $total     = $query->count();
        $coverages = $query->skip(($page-1)*$perPage)->take($perPage)->get();

        if ($request->ajax()) {
            return response()->json([
                'html'      => view('partials.media-coverage-cards', ['coverages' => $coverages])->render(),
                'has_more'  => ($page * $perPage) < $total,
                'next_page' => $page + 1,
            ]);
        }
        $hasMore = $total > $perPage;
        return view('media-coverage', compact('coverages','hasMore','category'));
    }
}
