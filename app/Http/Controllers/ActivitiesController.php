<?php
namespace App\Http\Controllers;
use App\Models\Activity;
use Illuminate\Http\Request;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        $year  = $request->get('year');
        $query = Activity::where('is_active', true)->orderBy('sort_order')->orderByDesc('created_at');
        if ($year) $query->whereYear('created_at', $year);
        $items = $query->paginate(12)->withQueryString();
        $years = Activity::where('is_active', true)
            ->selectRaw('YEAR(created_at) as y')->groupBy('y')->orderByDesc('y')->pluck('y');
        return view('activities', compact('items', 'years', 'year'));
    }
}
