<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Event;
use App\Models\FuturePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContentController extends Controller
{
    use ManagesSortOrder;

    private array $types = [
        'activities'   => ['model' => Activity::class,   'view' => 'activities',   'label' => 'Activity'],
        'events'       => ['model' => Event::class,       'view' => 'events',       'label' => 'Event'],
        'future-plans' => ['model' => FuturePlan::class,  'view' => 'future_plans', 'label' => 'Future Plan'],
    ];

    private function resolve(string $type): array
    {
        if (!isset($this->types[$type])) abort(404);
        return $this->types[$type];
    }

    public function index(string $type)
    {
        $cfg         = $this->resolve($type);
        $currentYear = (int) now()->format('Y');
        $year        = request('year') ? (int) request('year') : $currentYear;

        $query = ($cfg['model'])::orderBy('sort_order')->orderBy('id')
                    ->where('post_year', $year);

        if ($status = request('status')) {
            $query->where('is_active', $status === 'active');
        }

        $items      = $query->paginate(20)->withQueryString();
        $availYears = ($cfg['model'])::selectRaw('post_year as y')
            ->groupBy('post_year')->orderByDesc('post_year')->pluck('y');

        return view('admin.content.index', compact('items', 'type', 'cfg', 'availYears', 'year', 'currentYear'));
    }

    public function reorder(Request $request, string $type): \Illuminate\Http\JsonResponse
    {
        $cfg = $this->resolve($type);
        $ids = $request->input('ids', []);
        foreach ($ids as $position => $id) {
            ($cfg['model'])::where('id', $id)->update(['sort_order' => $position]);
        }
        return response()->json(['ok' => true]);
    }

    public function create(string $type)
    {
        $cfg       = $this->resolve($type);
        $nextOrder = $this->nextSortOrder($cfg['model'], ['post_year' => (int) now()->format('Y')]);
        return view('admin.content.form', ['item' => null, 'type' => $type, 'cfg' => $cfg, 'nextOrder' => $nextOrder]);
    }

    public function store(Request $request, string $type)
    {
        $cfg       = $this->resolve($type);
        $data      = $this->validated($request);
        $scope     = ['post_year' => $data['post_year']];
        $nextOrder = $this->nextSortOrder($cfg['model'], $scope); // before insert

        $data['image_url'] = null;
        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store($cfg['view'], 'public');
        }

        $item = ($cfg['model'])::create($data);
        $this->swapSortOrderIfConflict($cfg['model'], $item->id, $data['sort_order'], $nextOrder, $scope);

        return redirect()->route('admin.content.index', $type)->with('success', $cfg['label'] . ' added successfully.');
    }

    public function edit(string $type, int $id)
    {
        $cfg  = $this->resolve($type);
        $item = ($cfg['model'])::findOrFail($id);
        return view('admin.content.form', compact('item', 'type', 'cfg'));
    }

    public function update(Request $request, string $type, int $id)
    {
        $cfg      = $this->resolve($type);
        $item     = ($cfg['model'])::findOrFail($id);
        $oldOrder = $item->sort_order;
        $data     = $this->validated($request);
        $scope    = ['post_year' => $data['post_year']];

        if ($request->hasFile('image')) {
            if ($item->image_url) Storage::disk('public')->delete($item->image_url);
            $data['image_url'] = $request->file('image')->store($cfg['view'], 'public');
        } else {
            $data['image_url'] = $item->image_url;
        }

        $item->update($data);
        $this->swapSortOrderIfConflict($cfg['model'], $item->id, $data['sort_order'], $oldOrder, $scope);

        return redirect()->route('admin.content.index', $type)->with('success', $cfg['label'] . ' updated successfully.');
    }

    public function destroy(string $type, int $id)
    {
        $cfg  = $this->resolve($type);
        $item = ($cfg['model'])::findOrFail($id);
        if ($item->image_url) Storage::disk('public')->delete($item->image_url);
        $item->delete();
        return back()->with('success', $cfg['label'] . ' deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'heading'     => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'image'       => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'youtube_url' => ['nullable', 'url', 'max:300'],
            'sort_order'  => ['integer', 'min:0'],
            'post_year'   => ['required', 'integer', 'min:2000', 'max:2100'],
            'is_active'   => ['boolean'],
        ]) + [
            'sort_order' => $request->input('sort_order', 0),
            'post_year'  => $request->input('post_year', (int) now()->format('Y')),
            'is_active'  => $request->boolean('is_active'),
        ];
    }
}
