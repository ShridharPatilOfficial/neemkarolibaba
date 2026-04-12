<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Event;
use App\Models\FuturePlan;
use App\Models\RecentActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Handles CRUD for: Recent Activities, Activities, Events, Future Plans
 * All share the same schema: heading, description, image_url, youtube_url, sort_order, is_active
 */
class ContentController extends Controller
{
    private array $types = [
        'recent-activities' => ['model' => RecentActivity::class, 'view' => 'recent_activities', 'label' => 'Recent Activity'],
        'activities'        => ['model' => Activity::class,       'view' => 'activities',        'label' => 'Activity'],
        'events'            => ['model' => Event::class,          'view' => 'events',            'label' => 'Event'],
        'future-plans'      => ['model' => FuturePlan::class,     'view' => 'future_plans',      'label' => 'Future Plan'],
    ];

    private function resolve(string $type): array
    {
        if (!isset($this->types[$type])) abort(404);
        return $this->types[$type];
    }

    public function index(string $type)
    {
        $cfg   = $this->resolve($type);
        $items = ($cfg['model'])::orderBy('sort_order')->get();
        return view('admin.content.index', compact('items', 'type', 'cfg'));
    }

    public function create(string $type)
    {
        $cfg = $this->resolve($type);
        return view('admin.content.form', ['item' => null, 'type' => $type, 'cfg' => $cfg]);
    }

    public function store(Request $request, string $type)
    {
        $cfg  = $this->resolve($type);
        $data = $this->validated($request);
        $data['image_url'] = null;

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store($cfg['view'], 'public');
        }

        ($cfg['model'])::create($data);
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
        $cfg  = $this->resolve($type);
        $item = ($cfg['model'])::findOrFail($id);
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($item->image_url) {
                Storage::disk('public')->delete($item->image_url);
            }
            $data['image_url'] = $request->file('image')->store($cfg['view'], 'public');
        } else {
            $data['image_url'] = $item->image_url;
        }

        $item->update($data);
        return redirect()->route('admin.content.index', $type)->with('success', $cfg['label'] . ' updated successfully.');
    }

    public function destroy(string $type, int $id)
    {
        $cfg  = $this->resolve($type);
        $item = ($cfg['model'])::findOrFail($id);
        if ($item->image_url) {
            Storage::disk('public')->delete($item->image_url);
        }
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
            'is_active'   => ['boolean'],
        ]) + [
            'sort_order' => $request->input('sort_order', 0),
            'is_active'  => $request->boolean('is_active'),
        ];
    }
}
