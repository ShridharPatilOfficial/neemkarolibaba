<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\MediaCoverage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaCoverageController extends Controller {
    public function index() {
        $coverages = MediaCoverage::orderBy('sort_order')->get();
        return view('admin.media-coverage.index', compact('coverages'));
    }
    public function create() {
        $coverage   = null;
        $categories = MediaCoverage::categories();
        return view('admin.media-coverage.form', compact('coverage','categories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'title'          => ['required','string','max:200'],
            'description'    => ['nullable','string'],
            'source_name'    => ['required','string','max:120'],
            'source_url'     => ['nullable','url'],
            'youtube_url'    => ['nullable','url'],
            'cover_image'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:1024'],
            'published_date' => ['nullable','date'],
            'category'       => ['required','in:news,tv,online,magazine'],
            'sort_order'     => ['nullable','integer'],
            'is_active'      => ['nullable','boolean'],
        ]);
        if ($request->hasFile('cover_image')) {
            $data['cover_image_url'] = $request->file('cover_image')->store('media-coverage', 'public');
        }
        unset($data['cover_image']);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        MediaCoverage::create($data);
        return redirect()->route('admin.media-coverage.index')->with('success', 'Media coverage added.');
    }
    public function edit(MediaCoverage $mediaCoverage) {
        $coverage   = $mediaCoverage;
        $categories = MediaCoverage::categories();
        return view('admin.media-coverage.form', compact('coverage','categories'));
    }
    public function update(Request $request, MediaCoverage $mediaCoverage) {
        $data = $request->validate([
            'title'          => ['required','string','max:200'],
            'description'    => ['nullable','string'],
            'source_name'    => ['required','string','max:120'],
            'source_url'     => ['nullable','url'],
            'youtube_url'    => ['nullable','url'],
            'cover_image'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:1024'],
            'published_date' => ['nullable','date'],
            'category'       => ['required','in:news,tv,online,magazine'],
            'sort_order'     => ['nullable','integer'],
            'is_active'      => ['nullable','boolean'],
        ]);
        if ($request->hasFile('cover_image')) {
            if ($mediaCoverage->cover_image_url && !str_starts_with($mediaCoverage->cover_image_url,'http')) {
                Storage::disk('public')->delete($mediaCoverage->cover_image_url);
            }
            $data['cover_image_url'] = $request->file('cover_image')->store('media-coverage', 'public');
        }
        unset($data['cover_image']);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $mediaCoverage->update($data);
        return redirect()->route('admin.media-coverage.index')->with('success', 'Media coverage updated.');
    }
    public function destroy(MediaCoverage $mediaCoverage) {
        if ($mediaCoverage->cover_image_url && !str_starts_with($mediaCoverage->cover_image_url,'http')) {
            Storage::disk('public')->delete($mediaCoverage->cover_image_url);
        }
        $mediaCoverage->delete();
        return back()->with('success', 'Deleted.');
    }
}
