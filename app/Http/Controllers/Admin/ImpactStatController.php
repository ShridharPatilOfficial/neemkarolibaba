<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImpactStat;
use Illuminate\Http\Request;

class ImpactStatController extends Controller
{
    public function index()
    {
        $stats = ImpactStat::orderBy('sort_order')->get();
        return view('admin.stats.index', compact('stats'));
    }

    public function create()
    {
        return view('admin.stats.form', ['stat' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'number_value' => ['required', 'string', 'max:20'],
            'label'        => ['required', 'string', 'max:100'],
            'icon_class'   => ['nullable', 'string', 'max:50'],
            'sort_order'   => ['integer', 'min:0'],
            'is_active'    => ['boolean'],
        ]);

        ImpactStat::create([
            'number_value' => $data['number_value'],
            'label'        => $data['label'],
            'icon_class'   => $data['icon_class'] ?? null,
            'sort_order'   => $data['sort_order'] ?? 0,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.stats.index')->with('success', 'Stat added.');
    }

    public function edit(ImpactStat $stat)
    {
        return view('admin.stats.form', compact('stat'));
    }

    public function update(Request $request, ImpactStat $stat)
    {
        $data = $request->validate([
            'number_value' => ['required', 'string', 'max:20'],
            'label'        => ['required', 'string', 'max:100'],
            'icon_class'   => ['nullable', 'string', 'max:50'],
            'sort_order'   => ['integer', 'min:0'],
            'is_active'    => ['boolean'],
        ]);

        $stat->update([
            'number_value' => $data['number_value'],
            'label'        => $data['label'],
            'icon_class'   => $data['icon_class'] ?? null,
            'sort_order'   => $data['sort_order'] ?? 0,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.stats.index')->with('success', 'Stat updated.');
    }

    public function destroy(ImpactStat $stat)
    {
        $stat->delete();
        return back()->with('success', 'Stat deleted.');
    }
}
