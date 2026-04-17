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

        $items = Event::where('is_active', true)
            ->where('post_year', $year)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate(12)
            ->withQueryString();

        $availYears = Event::where('is_active', true)
            ->selectRaw('post_year as y')
            ->groupBy('post_year')
            ->orderByDesc('post_year')
            ->pluck('y');

        return view('events', compact('items', 'availYears', 'year', 'currentYear'));
    }
}
