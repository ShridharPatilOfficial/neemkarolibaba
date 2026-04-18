<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    use ManagesSortOrder;

    public function index()
    {
        $partners = Partner::orderBy('sort_order')->get();
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        $nextOrder = $this->nextSortOrder(Partner::class);
        return view('admin.partners.form', ['partner' => null, 'nextOrder' => $nextOrder]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'logo'        => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'website_url' => ['nullable', 'url', 'max:200'],
            'sort_order'  => ['integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $nextOrder = $this->nextSortOrder(Partner::class);
        $path = $request->file('logo')->store('partners', 'public');

        $item = Partner::create([
            'name'        => $data['name'],
            'logo_url'    => $path,
            'website_url' => $data['website_url'] ?? null,
            'sort_order'  => $data['sort_order'] ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(Partner::class, $item->id, $item->sort_order, $nextOrder);

        return redirect()->route('admin.partners.index')->with('success', 'Partner added successfully.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.form', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'logo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'website_url' => ['nullable', 'url', 'max:200'],
            'sort_order'  => ['integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $oldOrder = $partner->sort_order;
        $logoUrl  = $partner->logo_url;

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($partner->logo_url);
            $logoUrl = $request->file('logo')->store('partners', 'public');
        }

        $partner->update([
            'name'        => $data['name'],
            'logo_url'    => $logoUrl,
            'website_url' => $data['website_url'] ?? null,
            'sort_order'  => $data['sort_order'] ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(Partner::class, $partner->id, $partner->sort_order, $oldOrder);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated successfully.');
    }

    public function destroy(Partner $partner)
    {
        Storage::disk('public')->delete($partner->logo_url);
        $partner->delete();
        return back()->with('success', 'Partner deleted.');
    }
}
