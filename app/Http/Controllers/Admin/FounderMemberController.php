<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\FounderMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FounderMemberController extends Controller
{
    use ManagesSortOrder;

    public function index()
    {
        $members = FounderMember::orderBy('sort_order')->get();
        return view('admin.members.index', compact('members'));
    }

    public function create()
    {
        $nextOrder = $this->nextSortOrder(FounderMember::class);
        return view('admin.members.form', ['member' => null, 'nextOrder' => $nextOrder]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'role'        => ['required', 'string', 'max:100'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'sort_order'  => ['integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $nextOrder = $this->nextSortOrder(FounderMember::class);
        $photoUrl  = null;
        if ($request->hasFile('photo')) {
            $photoUrl = $request->file('photo')->store('members', 'public');
        }

        $item = FounderMember::create([
            'name'        => $data['name'],
            'role'        => $data['role'],
            'website_url' => $data['website_url'] ?? null,
            'photo_url'   => $photoUrl,
            'sort_order'  => $data['sort_order'] ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(FounderMember::class, $item->id, $item->sort_order, $nextOrder);

        return redirect()->route('admin.members.index')->with('success', 'Member added.');
    }

    public function edit(FounderMember $member)
    {
        return view('admin.members.form', compact('member'));
    }

    public function update(Request $request, FounderMember $member)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'role'        => ['required', 'string', 'max:100'],
            'website_url' => ['nullable', 'url', 'max:255'],
            'photo'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:1024'],
            'sort_order'  => ['integer', 'min:0'],
            'is_active'   => ['boolean'],
        ]);

        $oldOrder = $member->sort_order;
        $photoUrl = $member->photo_url;

        if ($request->hasFile('photo')) {
            if ($member->photo_url) Storage::disk('public')->delete($member->photo_url);
            $photoUrl = $request->file('photo')->store('members', 'public');
        }

        $member->update([
            'name'        => $data['name'],
            'role'        => $data['role'],
            'website_url' => $data['website_url'] ?? null,
            'photo_url'   => $photoUrl,
            'sort_order'  => $data['sort_order'] ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(FounderMember::class, $member->id, $member->sort_order, $oldOrder);

        return redirect()->route('admin.members.index')->with('success', 'Member updated.');
    }

    public function destroy(FounderMember $member)
    {
        if ($member->photo_url) Storage::disk('public')->delete($member->photo_url);
        $member->delete();
        return back()->with('success', 'Member deleted.');
    }
}
