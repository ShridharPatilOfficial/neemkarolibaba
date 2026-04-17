<?php
namespace App\Http\Controllers;
use App\Models\MediaCoverage;
use Illuminate\Http\Request;

class MediaCoverageController extends Controller
{
    public function index(Request $request)
    {
        $year     = $request->get('year');
        $category = $request->get('category');
        $query    = MediaCoverage::where('is_active', true)->orderByDesc('published_date')->orderBy('sort_order');
        if ($year)     $query->whereYear('published_date', $year);
        if ($category) $query->where('category', $category);
        $coverages = $query->paginate(9)->withQueryString();
        $years = MediaCoverage::where('is_active', true)
            ->whereNotNull('published_date')
            ->selectRaw('YEAR(published_date) as y')->groupBy('y')->orderByDesc('y')->pluck('y');
        return view('media-coverage', compact('coverages', 'years', 'year', 'category'));
    }
}
