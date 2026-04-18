<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\ImpactStat;
use Illuminate\Http\Request;

class ImpactStatController extends Controller
{
    use ManagesSortOrder;

    public function index()
    {
        $stats = ImpactStat::orderBy('sort_order')->get();
        return view('admin.stats.index', compact('stats'));
    }

    public function create()
    {
        $nextOrder = $this->nextSortOrder(ImpactStat::class);
        return view('admin.stats.form', ['stat' => null, 'nextOrder' => $nextOrder]);
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

        $nextOrder = $this->nextSortOrder(ImpactStat::class);

        $item = ImpactStat::create([
            'number_value' => $data['number_value'],
            'label'        => $data['label'],
            'icon_class'   => $data['icon_class'] ?? null,
            'sort_order'   => $data['sort_order'] ?? 0,
            'is_active'    => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(ImpactStat::class, $item->id, $item->sort_order, $nextOrder);

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

        $oldOrder = $stat->sort_order;

        $stat->update([
            'number_value' => $data['number_value'],
            'label'        => $data['label'],
            'icon_class'   => $data['icon_class'] ?? null,
            'sort_order'   => $data['sort_order'] ?? 0,
            'is_active'    => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(ImpactStat::class, $stat->id, $stat->sort_order, $oldOrder);

        return redirect()->route('admin.stats.index')->with('success', 'Stat updated.');
    }

    public function destroy(ImpactStat $stat)
    {
        $stat->delete();
        return back()->with('success', 'Stat deleted.');
    }
}
