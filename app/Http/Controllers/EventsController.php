<?php
namespace App\Http\Controllers;
use App\Models\Event;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = (int) now()->format('Y');
        $year        = $request->input('year') ? (int) $request->input('year') : $currentYear;
        $perPage     = in_array((int) $request->input('per_page'), [25, 50, 100]) ? (int) $request->input('per_page') : 25;

        $items = Event::where('is_active', true)
            ->where('post_year', $year)
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        $availYears = Event::where('is_active', true)
            ->selectRaw('post_year as y')
            ->groupBy('post_year')
            ->orderByDesc('post_year')
            ->pluck('y');

        return view('events', compact('items', 'availYears', 'year', 'currentYear', 'perPage'));
    }
}
