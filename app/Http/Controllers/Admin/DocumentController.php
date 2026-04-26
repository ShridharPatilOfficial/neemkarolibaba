<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ManagesSortOrder;
use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    use ManagesSortOrder;

    public function index()
    {
        // Admin sees ALL documents (active and inactive)
        $documents = Document::orderBy('sort_order')->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $nextOrder = $this->nextSortOrder(Document::class);
        return view('admin.documents.form', ['document' => null, 'nextOrder' => $nextOrder]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:150'],
            'file'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $file      = $request->file('file');
        $path      = $file->store('documents', 'public');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileType  = in_array($extension, ['doc', 'docx']) ? 'docx' : 'pdf';
        $nextOrder = $this->nextSortOrder(Document::class);

        $item = Document::create([
            'name'       => $data['name'],
            'file_path'  => $path,
            'file_type'  => $fileType,
            'sort_order' => $data['sort_order'] ?? $nextOrder,
            'is_active'  => $request->boolean('is_active'),
        ]);

        $this->swapSortOrderIfConflict(Document::class, $item->id, $item->sort_order, $nextOrder);

        return redirect()->route('admin.documents.index')->with('success', 'Document added.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.form', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $request->validate([
            'name'       => ['required', 'string', 'max:150'],
            'file'       => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active'  => ['nullable', 'boolean'],
        ]);

        $filePath = $document->file_path;
        $fileType = $document->file_type;

        if ($request->hasFile('file')) {
            if ($filePath && Storage::disk('public')->exists($filePath)) {
                Storage::disk('public')->delete($filePath);
            }
            $file     = $request->file('file');
            $filePath = $file->store('documents', 'public');
            $ext      = strtolower($file->getClientOriginalExtension());
            $fileType = in_array($ext, ['doc', 'docx']) ? 'docx' : 'pdf';
        }

        $document->update([
            'name'       => $request->input('name'),
            'file_path'  => $filePath,
            'file_type'  => $fileType,
            'sort_order' => $request->input('sort_order', $document->sort_order) ?? $document->sort_order,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document updated.');
    }

    public function destroy(Document $document)
    {
        if ($document->file_path && Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();
        return back()->with('success', 'Document deleted.');
    }

    public function reorder(Request $request)
    {
        $ids = $request->input('ids', []);
        foreach ($ids as $index => $id) {
            Document::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        return response()->json(['ok' => true]);
    }
}
