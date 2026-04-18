<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\WorkVideo;
use Illuminate\Http\Request;

class WorkVideoController extends Controller
{
    use ManagesSortOrder;

    public function index()
    {
        $videos = WorkVideo::orderBy('sort_order')->get();
        return view('admin.work-videos.index', compact('videos'));
    }

    public function create()
    {
        $video     = null;
        $nextOrder = $this->nextSortOrder(WorkVideo::class);
        return view('admin.work-videos.form', compact('video', 'nextOrder'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'         => ['required', 'string', 'max:150'],
            'description'   => ['nullable', 'string'],
            'youtube_url'   => ['required', 'url'],
            'thumbnail_url' => ['nullable', 'url'],
            'sort_order'    => ['nullable', 'integer'],
            'post_year'     => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'is_active'     => ['nullable', 'boolean'],
        ]);

        $nextOrder          = $this->nextSortOrder(WorkVideo::class);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['post_year']  = $data['post_year'] ?? now()->year;

        $item = WorkVideo::create($data);
        $this->swapSortOrderIfConflict(WorkVideo::class, $item->id, $item->sort_order, $nextOrder);

        return redirect()->route('admin.work-videos.index')->with('success', 'Video added successfully.');
    }

    public function edit(WorkVideo $workVideo)
    {
        $video = $workVideo;
        return view('admin.work-videos.form', compact('video'));
    }

    public function update(Request $request, WorkVideo $workVideo)
    {
        $data = $request->validate([
            'title'         => ['required', 'string', 'max:150'],
            'description'   => ['nullable', 'string'],
            'youtube_url'   => ['required', 'url'],
            'thumbnail_url' => ['nullable', 'url'],
            'sort_order'    => ['nullable', 'integer'],
            'post_year'     => ['nullable', 'integer', 'min:2000', 'max:2100'],
            'is_active'     => ['nullable', 'boolean'],
        ]);

        $oldOrder           = $workVideo->sort_order;
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['post_year']  = $data['post_year'] ?? now()->year;

        $workVideo->update($data);
        $this->swapSortOrderIfConflict(WorkVideo::class, $workVideo->id, $workVideo->sort_order, $oldOrder);

        return redirect()->route('admin.work-videos.index')->with('success', 'Video updated.');
    }

    public function destroy(WorkVideo $workVideo)
    {
        $workVideo->delete();
        return back()->with('success', 'Video deleted.');
    }

    public function reorder(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            WorkVideo::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['ok' => true]);
    }
}
