<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\Principle;
use Illuminate\Http\Request;

class PrincipleController extends Controller
{
    use ManagesSortOrder;

    public function index()
    {
        $principles = Principle::orderBy('sort_order')->get();
        return view('admin.principles.index', compact('principles'));
    }

    public function create()
    {
        $principle = null;
        $themes    = Principle::themeMap();
        $nextOrder = $this->nextSortOrder(Principle::class);
        return view('admin.principles.form', compact('principle', 'themes', 'nextOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'icon'        => ['required', 'string', 'max:80'],
            'color_theme' => ['required', 'string', 'in:orange,purple,emerald,blue,teal,red,yellow,pink'],
            'link_url'    => ['nullable', 'url', 'max:255'],
            'sort_order'  => ['nullable', 'integer'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $nextOrder          = $this->nextSortOrder(Principle::class);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $item = Principle::create($data);
        $this->swapSortOrderIfConflict(Principle::class, $item->id, $item->sort_order, $nextOrder);

        return redirect()->route('admin.principles.index')->with('success', 'Principle added successfully.');
    }

    public function edit(Principle $principle)
    {
        $themes = Principle::themeMap();
        return view('admin.principles.form', compact('principle', 'themes'));
    }

    public function update(Request $request, Principle $principle)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:120'],
            'description' => ['required', 'string'],
            'icon'        => ['required', 'string', 'max:80'],
            'color_theme' => ['required', 'string', 'in:orange,purple,emerald,blue,teal,red,yellow,pink'],
            'link_url'    => ['nullable', 'url', 'max:255'],
            'sort_order'  => ['nullable', 'integer'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $oldOrder           = $principle->sort_order;
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $principle->update($data);
        $this->swapSortOrderIfConflict(Principle::class, $principle->id, $principle->sort_order, $oldOrder);

        return redirect()->route('admin.principles.index')->with('success', 'Principle updated successfully.');
    }

    public function destroy(Principle $principle)
    {
        $principle->delete();
        return back()->with('success', 'Principle deleted.');
    }
}
