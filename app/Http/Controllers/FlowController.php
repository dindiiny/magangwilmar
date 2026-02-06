<?php

namespace App\Http\Controllers;

use App\Models\ProcessFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FlowController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->only([
            'storeFlow',
            'updateFlow',
            'destroyFlow',
        ]);
    }

    public function index()
    {
        $flows = ProcessFlow::orderBy('order')->get();
        return view('flow', compact('flows'));
    }

    public function storeFlow(Request $request)
    {
        $request->validate([
            'step_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'order' => 'integer',
        ]);

        $data = $request->only(['step_name', 'description', 'order']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('flows', 'public');
        }

        ProcessFlow::create($data);

        return redirect()->route('flow')->with('success', 'Alur proses berhasil ditambahkan.');
    }

    public function updateFlow(Request $request, $id)
    {
        $request->validate([
            'step_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'order' => 'integer',
        ]);

        $flow = ProcessFlow::findOrFail($id);
        
        // Logika Reordering Otomatis
        if ($request->has('order') && $request->order != $flow->order) {
            $oldOrder = $flow->order;
            $newOrder = $request->order;

            if ($newOrder < $oldOrder) {
                // Geser item lain ke bawah (increment order)
                ProcessFlow::where('order', '>=', $newOrder)
                    ->where('order', '<', $oldOrder)
                    ->increment('order');
            } else {
                // Geser item lain ke atas (decrement order)
                ProcessFlow::where('order', '>', $oldOrder)
                    ->where('order', '<=', $newOrder)
                    ->decrement('order');
            }
        }

        $data = $request->only(['step_name', 'description', 'order']);

        if ($request->hasFile('image')) {
            if ($flow->image) {
                Storage::disk('public')->delete($flow->image);
            }
            $data['image'] = $request->file('image')->store('flows', 'public');
        }

        $flow->update($data);

        return redirect()->route('flow')->with('success', 'Alur proses berhasil diperbarui.');
    }

    public function destroyFlow($id)
    {
        $flow = ProcessFlow::findOrFail($id);
        if ($flow->image) {
            Storage::disk('public')->delete($flow->image);
        }
        $flow->delete();

        return redirect()->route('flow')->with('success', 'Alur proses berhasil dihapus.');
    }
}
