<?php

namespace App\Http\Controllers;

use App\Models\LabEquipment;
use App\Models\Product;
use App\Models\SOPPengujian;
use App\Models\SevenS;
use App\Models\HouseKeeping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function houseKeeping()
    {
        $houseKeeping = HouseKeeping::first();

        return view('housekeeping', compact('houseKeeping'));
    }

    public function sevenS()
    {
        $sevenS = SevenS::first();

        return view('sevens', compact('sevenS'));
    }

    public function index()
    {
        $instruments = LabEquipment::where('category', 'instrument')->get();
        $glassware = LabEquipment::where('category', 'glassware')->get();
        $products = Product::all();
        $sops = SOPPengujian::all();
        $sevenS = SevenS::first();

        return view('laboratorium', compact('instruments', 'glassware', 'products', 'sops', 'sevenS'));
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

    public function storeSevenS(Request $request)
    {
        $request->validate([
            'progress_percent' => 'nullable|integer|min:0|max:100',
            'before_image' => 'nullable|image|max:4096',
            'after_image' => 'nullable|image|max:4096',
            'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'seiri' => 'nullable|boolean',
            'seiton' => 'nullable|boolean',
            'seiso' => 'nullable|boolean',
            'seiketsu' => 'nullable|boolean',
            'shitsuke' => 'nullable|boolean',
            'safety_spirit' => 'nullable|boolean',
            'report' => 'nullable|string',
            'published' => 'nullable|boolean',
        ]);

        $sevenS = SevenS::first();
        $data = [
            'seiri' => (bool)$request->input('seiri'),
            'seiton' => (bool)$request->input('seiton'),
            'seiso' => (bool)$request->input('seiso'),
            'seiketsu' => (bool)$request->input('seiketsu'),
            'shitsuke' => (bool)$request->input('shitsuke'),
            'safety_spirit' => (bool)$request->input('safety_spirit'),
            'report' => $request->input('report'),
            'published' => $request->input('published', true) ? true : false,
        ];

        if ($request->hasFile('before_image')) {
            if ($sevenS && $sevenS->before_image) {
                Storage::disk('public')->delete($sevenS->before_image);
            }
            $data['before_image'] = $request->file('before_image')->store('seven_s', 'public');
        }

        if ($request->hasFile('after_image')) {
            if ($sevenS && $sevenS->after_image) {
                Storage::disk('public')->delete($sevenS->after_image);
            }
            $data['after_image'] = $request->file('after_image')->store('seven_s', 'public');
        }

        if ($request->hasFile('report_file')) {
            if ($sevenS && $sevenS->report_file) {
                Storage::disk('public')->delete($sevenS->report_file);
            }
            $data['report_file'] = $request->file('report_file')->store('seven_s/reports', 'public');
        }

        $checked = 0;
        $totalChecklist = 6;
        $checked += $data['seiri'] ? 1 : 0;
        $checked += $data['seiton'] ? 1 : 0;
        $checked += $data['seiso'] ? 1 : 0;
        $checked += $data['seiketsu'] ? 1 : 0;
        $checked += $data['shitsuke'] ? 1 : 0;
        $checked += $data['safety_spirit'] ? 1 : 0;
        $hasBefore = isset($data['before_image']) || ($sevenS && $sevenS->before_image);
        $hasAfter = isset($data['after_image']) || ($sevenS && $sevenS->after_image);
        $hasReport = !empty($data['report']) || isset($data['report_file']) || ($sevenS && $sevenS->report_file);
        $base = ($checked / $totalChecklist) * 70;
        $photos = ($hasBefore ? 10 : 0) + ($hasAfter ? 10 : 0);
        $reportScore = $hasReport ? 10 : 0;
        $data['progress_percent'] = (int)round($base + $photos + $reportScore);

        if ($sevenS) {
            $sevenS->update($data);
        } else {
            SevenS::create($data);
        }

        return redirect()->route('sevens')->with('success', 'Data 7S berhasil diperbarui.');
    }

    public function storeHouseKeeping(Request $request)
    {
        $request->validate([
            'weekly_schedule' => 'nullable|string',
            'areas' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:51200',
            'published' => 'nullable|boolean',
        ]);

        $houseKeeping = HouseKeeping::first();
        $data = [
            'weekly_schedule' => $request->input('weekly_schedule'),
            'areas' => $request->input('areas'),
            'published' => $request->input('published', true) ? true : false,
        ];

        if ($request->hasFile('video')) {
            if ($houseKeeping && $houseKeeping->video_path) {
                Storage::disk('public')->delete($houseKeeping->video_path);
            }
            $data['video_path'] = $request->file('video')->store('housekeeping/videos', 'public');
        }

        if ($houseKeeping) {
            $houseKeeping->update($data);
        } else {
            HouseKeeping::create($data);
        }

        return redirect()->route('housekeeping')->with('success', 'Data House Keeping berhasil diperbarui.');
    }
}
