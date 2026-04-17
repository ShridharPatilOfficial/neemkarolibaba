<?php
namespace App\Http\Controllers;
use App\Models\MediaCoverage;
use Illuminate\Http\Request;

class MediaCoverageController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = (int) now()->format('Y');
        $year        = $request->input('year') ? (int) $request->input('year') : $currentYear;
        $category    = $request->input('category');

        $query = MediaCoverage::where('is_active', true)
            ->whereYear('published_date', $year)
            ->orderBy('sort_order')
            ->orderByDesc('published_date');

        if ($category) $query->where('category', $category);

        $coverages  = $query->paginate(9)->withQueryString();
        $availYears = MediaCoverage::where('is_active', true)
            ->whereNotNull('published_date')
            ->selectRaw('YEAR(published_date) as y')
            ->groupBy('y')->orderByDesc('y')->pluck('y');

        return view('media-coverage', compact('coverages', 'availYears', 'year', 'currentYear', 'category'));
    }
}
