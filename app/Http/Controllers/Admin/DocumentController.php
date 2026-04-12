<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::orderBy('sort_order')->get();
        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        return view('admin.documents.form', ['document' => null]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:150'],
            'file'       => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'sort_order' => ['integer', 'min:0'],
            'is_active'  => ['boolean'],
        ]);

        $file      = $request->file('file');
        $path      = $file->store('documents', 'public');
        $extension = strtolower($file->getClientOriginalExtension());
        $fileType  = in_array($extension, ['doc', 'docx']) ? 'docx' : 'pdf';

        Document::create([
            'name'       => $data['name'],
            'file_path'  => $path,
            'file_type'  => $fileType,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document added.');
    }

    public function edit(Document $document)
    {
        return view('admin.documents.form', compact('document'));
    }

    public function update(Request $request, Document $document)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:150'],
            'file'       => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
            'sort_order' => ['integer', 'min:0'],
            'is_active'  => ['boolean'],
        ]);

        $filePath = $document->file_path;
        $fileType = $document->file_type;

        if ($request->hasFile('file')) {
            Storage::disk('public')->delete($document->file_path);
            $file      = $request->file('file');
            $filePath  = $file->store('documents', 'public');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileType  = in_array($extension, ['doc', 'docx']) ? 'docx' : 'pdf';
        }

        $document->update([
            'name'       => $data['name'],
            'file_path'  => $filePath,
            'file_type'  => $fileType,
            'sort_order' => $data['sort_order'] ?? 0,
            'is_active'  => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document updated.');
    }

    public function destroy(Document $document)
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();
        return back()->with('success', 'Document deleted.');
    }
}
