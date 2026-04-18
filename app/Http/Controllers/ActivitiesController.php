<?php
namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = (int) now()->format('Y');
        $year        = $request->input('year') ? (int) $request->input('year') : $currentYear;
        $perPage     = in_array((int) $request->input('per_page'), [25, 50, 100]) ? (int) $request->input('per_page') : 25;

        $items = Activity::where('is_active', true)
            ->where('post_year', $year)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();

        // All years that have at least one active record
        $availYears = Activity::where('is_active', true)
            ->selectRaw('post_year as y')
            ->groupBy('post_year')
            ->orderByDesc('post_year')
            ->pluck('y');

        return view('activities', compact('items', 'availYears', 'year', 'currentYear', 'perPage'));
    }
}
