<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\WorkVideo;
use Illuminate\Http\Request;

class WorkVideoController extends Controller {
    public function index() {
        $videos = WorkVideo::orderBy('sort_order')->get();
        return view('admin.work-videos.index', compact('videos'));
    }
    public function create() {
        $video = null;
        return view('admin.work-videos.form', compact('video'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'title'         => ['required','string','max:150'],
            'description'   => ['nullable','string'],
            'youtube_url'   => ['required','url'],
            'thumbnail_url' => ['nullable','url'],
            'sort_order'    => ['nullable','integer'],
            'is_active'     => ['nullable','boolean'],
        ]);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        WorkVideo::create($data);
        return redirect()->route('admin.work-videos.index')->with('success', 'Video added successfully.');
    }
    public function edit(WorkVideo $workVideo) {
        $video = $workVideo;
        return view('admin.work-videos.form', compact('video'));
    }
    public function update(Request $request, WorkVideo $workVideo) {
        $data = $request->validate([
            'title'         => ['required','string','max:150'],
            'description'   => ['nullable','string'],
            'youtube_url'   => ['required','url'],
            'thumbnail_url' => ['nullable','url'],
            'sort_order'    => ['nullable','integer'],
            'is_active'     => ['nullable','boolean'],
        ]);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $workVideo->update($data);
        return redirect()->route('admin.work-videos.index')->with('success', 'Video updated.');
    }
    public function destroy(WorkVideo $workVideo) {
        $workVideo->delete();
        return back()->with('success', 'Video deleted.');
    }
}
