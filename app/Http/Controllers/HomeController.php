<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\Structure;
use App\Models\PageContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::all();
        $structure = Structure::first();
        $pageContents = PageContent::all()->keyBy('section');
        return view('home', compact('teamMembers', 'structure', 'pageContents'));
    }

    public function updateContent(Request $request)
    {
        $request->validate([
            'section' => 'required|string|exists:page_contents,section',
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        PageContent::where('section', $request->section)->update([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return redirect()->route('home')->with('success', 'Konten berhasil diperbarui.');
    }

    // --- Team Methods ---
    public function storeTeam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ]);

        $data = $request->only(['name', 'role', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        TeamMember::create($data);

        return redirect()->route('home')->with('success', 'Anggota tim berhasil ditambahkan.');
    }

    public function updateTeam(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $team = TeamMember::findOrFail($id);
        $data = $request->only(['name', 'role', 'description']);

        if ($request->hasFile('image')) {
            if ($team->image) {
                Storage::disk('public')->delete($team->image);
            }
            $data['image'] = $request->file('image')->store('team', 'public');
        }

        $team->update($data);

        return redirect()->route('home')->with('success', 'Anggota tim berhasil diperbarui.');
    }

    public function destroyTeam($id)
    {
        $team = TeamMember::findOrFail($id);
        if ($team->image) {
            Storage::disk('public')->delete($team->image);
        }
        $team->delete();

        return redirect()->route('home')->with('success', 'Anggota tim berhasil dihapus.');
    }

    // --- Structure Methods ---
    public function storeStructure(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        // Use updateOrCreate to ensure only one structure exists (or simpler logic)
        // Actually, let's just assume we update the existing one or create if empty.
        
        $structure = Structure::first();
        $data = $request->only(['title', 'description']);

        if ($request->hasFile('image')) {
            if ($structure && $structure->image) {
                Storage::disk('public')->delete($structure->image);
            }
            $data['image'] = $request->file('image')->store('structure', 'public');
        }

        if ($structure) {
            $structure->update($data);
        } else {
            Structure::create($data);
        }

        return redirect()->route('home')->with('success', 'Struktur organisasi berhasil diperbarui.');
    }
}
