<?php

namespace App\Http\Controllers;

use App\Models\LabEquipment;
use App\Models\Product;
use App\Models\SOPPengujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function index()
    {
        $instruments = LabEquipment::where('category', 'instrument')->get();
        $glassware = LabEquipment::where('category', 'glassware')->get();
        $products = Product::all();
        $sops = SOPPengujian::all();

        return view('laboratorium', compact('instruments', 'glassware', 'products', 'sops'));
    }

    // --- Equipment Methods ---
    public function storeEquipment(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:instrument,glassware',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'category', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('equipment', 'public');
        }

        LabEquipment::create($data);

        return redirect()->route('laboratorium')->with('success', 'Peralatan berhasil ditambahkan.');
    }

    public function updateEquipment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:instrument,glassware',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $equipment = LabEquipment::findOrFail($id);
        $data = $request->only(['name', 'category', 'description']);

        if ($request->hasFile('image')) {
            if ($equipment->image) {
                Storage::disk('public')->delete($equipment->image);
            }
            $data['image'] = $request->file('image')->store('equipment', 'public');
        }

        $equipment->update($data);

        return redirect()->route('laboratorium')->with('success', 'Peralatan berhasil diperbarui.');
    }

    public function destroyEquipment($id)
    {
        $equipment = LabEquipment::findOrFail($id);
        if ($equipment->image) {
            Storage::disk('public')->delete($equipment->image);
        }
        $equipment->delete();

        return redirect()->route('laboratorium')->with('success', 'Peralatan berhasil dihapus.');
    }

    // --- Product Methods ---
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
        ]);

        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('laboratorium')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $product = Product::findOrFail($id);
        $data = $request->only(['name', 'description']);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('laboratorium')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();

        return redirect()->route('laboratorium')->with('success', 'Produk berhasil dihapus.');
    }

    // --- SOP Methods ---
    public function storeSOP(Request $request)
    {
        $request->validate([
            'parameter' => 'required|string|max:255',
            'metode' => 'required|string|max:255',
        ]);

        SOPPengujian::create($request->only(['parameter', 'metode']));

        return redirect()->route('laboratorium')->with('success', 'SOP berhasil ditambahkan.');
    }

    public function updateSOP(Request $request, $id)
    {
        $request->validate([
            'parameter' => 'required|string|max:255',
            'metode' => 'required|string|max:255',
        ]);

        $sop = SOPPengujian::findOrFail($id);
        $sop->update($request->only(['parameter', 'metode']));

        return redirect()->route('laboratorium')->with('success', 'SOP berhasil diperbarui.');
    }

    public function destroySOP($id)
    {
        $sop = SOPPengujian::findOrFail($id);
        $sop->delete();

        return redirect()->route('laboratorium')->with('success', 'SOP berhasil dihapus.');
    }
}
