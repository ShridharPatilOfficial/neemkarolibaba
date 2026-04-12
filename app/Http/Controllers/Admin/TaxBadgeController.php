<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\TaxBadge;
use Illuminate\Http\Request;

class TaxBadgeController extends Controller
{
    public function index()
    {
        $badges = TaxBadge::with('document')->orderBy('sort_order')->orderBy('id')->get();
        return view('admin.tax-badges.index', compact('badges'));
    }

    public function create()
    {
        $documents = Document::where('is_active', true)->orderBy('name')->get();
        return view('admin.tax-badges.form', compact('documents'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label'       => ['required', 'string', 'max:20'],
            'document_id' => ['nullable', 'exists:documents,id'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        TaxBadge::create($data);

        return redirect()->route('admin.tax-badges.index')->with('success', 'Badge added.');
    }

    public function edit(TaxBadge $taxBadge)
    {
        $documents = Document::where('is_active', true)->orderBy('name')->get();
        return view('admin.tax-badges.form', ['badge' => $taxBadge, 'documents' => $documents]);
    }

    public function update(Request $request, TaxBadge $taxBadge)
    {
        $data = $request->validate([
            'label'       => ['required', 'string', 'max:20'],
            'document_id' => ['nullable', 'exists:documents,id'],
            'sort_order'  => ['nullable', 'integer', 'min:0'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $taxBadge->update($data);

        return redirect()->route('admin.tax-badges.index')->with('success', 'Badge updated.');
    }

    public function destroy(TaxBadge $taxBadge)
    {
        $taxBadge->delete();
        return back()->with('success', 'Badge deleted.');
    }
}
