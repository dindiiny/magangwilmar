<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $coas = Document::where('type', 'coa')->get();
        $incomings = Document::where('type', 'incoming')->get();
        $msds = Document::where('type', 'msds')->get();
        
        return view('documents', compact('coas', 'incomings', 'msds'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:coa,incoming,msds',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:10240', // 10MB max, PDF only
        ]);

        $data = $request->only(['title', 'type', 'description']);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        Document::create($data);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:coa,incoming,msds',
            'description' => 'nullable|string',
            'file' => 'nullable|mimes:pdf|max:10240',
        ]);

        $document = Document::findOrFail($id);
        $data = $request->only(['title', 'type', 'description']);

        if ($request->hasFile('file')) {
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            $data['file_path'] = $request->file('file')->store('documents', 'public');
        }

        $document->update($data);

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        $document->delete();

        return redirect()->route('documents.index')->with('success', 'Dokumen berhasil dihapus.');
    }
}
