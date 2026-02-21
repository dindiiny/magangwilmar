<?php

namespace App\Http\Controllers;

use App\Models\LabEquipment;
use App\Models\Product;
use App\Models\SOPPengujian;
use App\Models\SevenS;
use App\Models\SevenReport;
use App\Models\HouseKeeping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LabController extends Controller
{
    public function houseKeeping()
    {
        $logs = HouseKeeping::orderBy('date', 'desc')
            ->orderBy('day_name')
            ->get();

        return view('housekeeping', compact('logs'));
    }

    public function sevenS()
    {
        $sevenS = SevenS::first();

        $reports = $sevenS
            ? SevenReport::where('seven_s_id', $sevenS->id)->orderBy('created_at', 'desc')->get()
            : collect();

        return view('sevens', compact('sevenS', 'reports'));
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
            'image' => 'nullable|image|max:5120',
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
            'image' => 'nullable|image|max:5120',
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
            'image' => 'required|image|max:5120',
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
            'image' => 'nullable|image|max:5120',
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
        $section = $request->input('section', 'checklist');

        $sevenS = SevenS::first();
        if (!$sevenS) {
            $sevenS = new SevenS();
            $sevenS->seiri = false;
            $sevenS->seiton = false;
            $sevenS->seiso = false;
            $sevenS->seiketsu = false;
            $sevenS->shitsuke = false;
            $sevenS->safety_spirit = false;
            $sevenS->before_image = null;
            $sevenS->after_image = null;
            $sevenS->report = null;
            $sevenS->report_file = null;
            $sevenS->published = true;
            $sevenS->progress_percent = 0;
        }

        if ($section === 'checklist') {
            $request->validate([
                'seiri' => 'nullable|boolean',
                'seiton' => 'nullable|boolean',
                'seiso' => 'nullable|boolean',
                'seiketsu' => 'nullable|boolean',
                'shitsuke' => 'nullable|boolean',
                'safety_spirit' => 'nullable|boolean',
            ]);

            $sevenS->seiri = (bool)$request->input('seiri');
            $sevenS->seiton = (bool)$request->input('seiton');
            $sevenS->seiso = (bool)$request->input('seiso');
            $sevenS->seiketsu = (bool)$request->input('seiketsu');
            $sevenS->shitsuke = (bool)$request->input('shitsuke');
            $sevenS->safety_spirit = (bool)$request->input('safety_spirit');
        } elseif ($section === 'photos') {
            $request->validate([
                'before_image' => 'nullable|image|max:5120',
                'after_image' => 'nullable|image|max:5120',
            ]);

            if ($request->hasFile('before_image')) {
                if ($sevenS->before_image) {
                    Storage::disk('public')->delete($sevenS->before_image);
                }
                $sevenS->before_image = $request->file('before_image')->store('seven_s', 'public');
            }

            if ($request->hasFile('after_image')) {
                if ($sevenS->after_image) {
                    Storage::disk('public')->delete($sevenS->after_image);
                }
                $sevenS->after_image = $request->file('after_image')->store('seven_s', 'public');
            }
        } elseif ($section === 'report') {
            $request->validate([
                'title' => 'nullable|string|max:255',
                'report' => 'nullable|string',
                'report_file' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
                'published' => 'nullable|boolean',
            ]);

            $reportId = $request->input('report_id');
            $report = null;

            if ($reportId) {
                $report = SevenReport::where('id', $reportId)
                    ->where('seven_s_id', $sevenS->id)
                    ->first();
            }

            if (!$report) {
                $report = new SevenReport();
                $report->seven_s_id = $sevenS->id;
            }

            $title = $request->input('title');
            if ($title !== null && $title !== '') {
                $report->title = $title;
            } elseif (!$report->title) {
                $nextNumber = SevenReport::where('seven_s_id', $sevenS->id)->count() + 1;
                $report->title = 'Laporan ' . $nextNumber;
            }

            $report->content = $request->input('report');

            if ($request->hasFile('report_file')) {
                if ($report->file_path) {
                    Storage::disk('public')->delete($report->file_path);
                }
                $report->file_path = $request->file('report_file')->store('seven_s/reports', 'public');
            }

            $report->save();

            $sevenS->published = $request->input('published', true) ? true : false;
        } elseif ($section === 'labels') {
            $request->validate([
                'seiri_text' => 'nullable|string|max:1000',
                'seiton_text' => 'nullable|string|max:1000',
                'seiso_text' => 'nullable|string|max:1000',
                'seiketsu_text' => 'nullable|string|max:1000',
                'shitsuke_text' => 'nullable|string|max:1000',
                'safety_text' => 'nullable|string|max:1000',
                'spirit_text' => 'nullable|string|max:1000',
            ]);

            $sevenS->seiri_text = $request->input('seiri_text') ?: 'Seiri (Sort) – pemilahan barang perlu dan tidak perlu.';
            $sevenS->seiton_text = $request->input('seiton_text') ?: 'Seiton (Set in Order) – penataan peralatan dan bahan kerja.';
            $sevenS->seiso_text = $request->input('seiso_text') ?: 'Seiso (Shine) – pembersihan rutin area kerja.';
            $sevenS->seiketsu_text = $request->input('seiketsu_text') ?: 'Seiketsu (Standardize) – standarisasi tata letak dan label.';
            $sevenS->shitsuke_text = $request->input('shitsuke_text') ?: 'Shitsuke (Sustain) – pembiasaan disiplin dan audit berkala.';
            $sevenS->safety_text = $request->input('safety_text') ?: 'Safety – aspek keselamatan di area kerja.';
            $sevenS->spirit_text = $request->input('spirit_text') ?: 'Spirit – budaya kerja positif dan kepedulian terhadap lingkungan kerja.';
        }

        $checked = 0;
        $totalChecklist = 6;
        $checked += $sevenS->seiri ? 1 : 0;
        $checked += $sevenS->seiton ? 1 : 0;
        $checked += $sevenS->seiso ? 1 : 0;
        $checked += $sevenS->seiketsu ? 1 : 0;
        $checked += $sevenS->shitsuke ? 1 : 0;
        $checked += $sevenS->safety_spirit ? 1 : 0;
        $hasBefore = !empty($sevenS->before_image);
        $hasAfter = !empty($sevenS->after_image);
        $hasReport = $sevenS->id
            ? SevenReport::where('seven_s_id', $sevenS->id)
                ->where(function ($query) {
                    $query->whereNotNull('content')
                        ->orWhereNotNull('file_path');
                })
                ->exists()
            : false;
        $base = ($checked / $totalChecklist) * 70;
        $photos = ($hasBefore ? 10 : 0) + ($hasAfter ? 10 : 0);
        $reportScore = $hasReport ? 10 : 0;
        $sevenS->progress_percent = (int)round($base + $photos + $reportScore);

        $sevenS->save();

        $message = 'Data 7S berhasil diperbarui.';
        if ($section === 'checklist') {
            $message = 'Checklist 7S berhasil diperbarui.';
        } elseif ($section === 'photos') {
            $message = 'Foto 7S berhasil diperbarui.';
        } elseif ($section === 'report') {
            $message = 'Laporan 7S berhasil diperbarui.';
        } elseif ($section === 'labels') {
            $message = 'Teks 7S berhasil diperbarui.';
        }

        return redirect()->route('sevens')->with('success', $message);
    }

    public function destroySevenS(Request $request)
    {
        $target = $request->input('target', 'report');

        $sevenS = SevenS::first();
        if ($sevenS) {
            if ($target === 'report') {
                $reportId = $request->input('report_id');
                if ($reportId) {
                    $report = SevenReport::where('id', $reportId)
                        ->where('seven_s_id', $sevenS->id)
                        ->first();
                    if ($report) {
                        if ($report->file_path) {
                            Storage::disk('public')->delete($report->file_path);
                        }
                        $report->delete();
                    }
                }
            } elseif ($target === 'before_image') {
                if ($sevenS->before_image) {
                    Storage::disk('public')->delete($sevenS->before_image);
                }
                $sevenS->before_image = null;
            } elseif ($target === 'after_image') {
                if ($sevenS->after_image) {
                    Storage::disk('public')->delete($sevenS->after_image);
                }
                $sevenS->after_image = null;
            } elseif ($target === 'checklist') {
                $sevenS->seiri = false;
                $sevenS->seiton = false;
                $sevenS->seiso = false;
                $sevenS->seiketsu = false;
                $sevenS->shitsuke = false;
                $sevenS->safety_spirit = false;
            }

            $checked = 0;
            $totalChecklist = 6;
            $checked += $sevenS->seiri ? 1 : 0;
            $checked += $sevenS->seiton ? 1 : 0;
            $checked += $sevenS->seiso ? 1 : 0;
            $checked += $sevenS->seiketsu ? 1 : 0;
            $checked += $sevenS->shitsuke ? 1 : 0;
            $checked += $sevenS->safety_spirit ? 1 : 0;
            $hasBefore = !empty($sevenS->before_image);
            $hasAfter = !empty($sevenS->after_image);
            $hasReport = $sevenS->id
                ? SevenReport::where('seven_s_id', $sevenS->id)
                    ->where(function ($query) {
                        $query->whereNotNull('content')
                            ->orWhereNotNull('file_path');
                    })
                    ->exists()
                : false;
            $base = ($checked / $totalChecklist) * 70;
            $photos = ($hasBefore ? 10 : 0) + ($hasAfter ? 10 : 0);
            $reportScore = $hasReport ? 10 : 0;
            $sevenS->progress_percent = (int)round($base + $photos + $reportScore);
            $sevenS->save();
        }

        $message = 'Data 7S berhasil diperbarui.';
        if ($target === 'report') {
            $message = 'Laporan 7S berhasil dihapus.';
        } elseif ($target === 'before_image') {
            $message = 'Foto before 7S berhasil dihapus.';
        } elseif ($target === 'after_image') {
            $message = 'Foto after 7S berhasil dihapus.';
        } elseif ($target === 'checklist') {
            $message = 'Checklist 7S berhasil direset.';
        }

        return redirect()->route('sevens')->with('success', $message);
    }

    public function storeHouseKeeping(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'day_name' => 'required|string|max:20',
            'activities' => 'required|string',
            'areas' => 'required|string',
            'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:5120',
            'published' => 'nullable|boolean',
        ]);

        $key = [
            'date' => $request->input('date'),
            'day_name' => $request->input('day_name'),
        ];

        $data = [
            'activities' => $request->input('activities'),
            'areas' => $request->input('areas'),
            'published' => $request->input('published', true) ? true : false,
        ];

        $existing = HouseKeeping::where($key)->first();

        if ($request->hasFile('video')) {
            if ($existing && $existing->video_path) {
                Storage::disk('public')->delete($existing->video_path);
            }
            $data['video_path'] = $request->file('video')->store('housekeeping/videos', 'public');
        }

        HouseKeeping::updateOrCreate($key, $data);

        return redirect()->route('housekeeping')->with('success', 'Data House Keeping berhasil diperbarui.');
    }

    public function destroyHouseKeeping($id)
    {
        $log = HouseKeeping::findOrFail($id);

        if ($log->video_path) {
            Storage::disk('public')->delete($log->video_path);
        }

        $log->delete();

        return redirect()->route('housekeeping')->with('success', 'Log House Keeping berhasil dihapus.');
    }
}
