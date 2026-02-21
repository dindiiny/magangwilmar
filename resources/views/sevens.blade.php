@extends('layouts.public')

@section('title', 'Kegiatan 7S - Wilmar Nabati Indonesia')

@section('content')
    <div class="max-w-7xl mx-auto space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Kegiatan 7S Laboratorium</h1>
            <p class="text-gray-600">
                Ringkasan penerapan 7S di area laboratorium yang dapat diakses publik.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Progress Improvement</h2>
                </div>
                <p class="text-sm text-gray-600 mb-3">
                    Gambaran umum progres perbaikan area kerja berdasarkan aktivitas 7S.
                </p>
                @php
                    $progress = isset($sevenS) && $sevenS ? ($sevenS->progress_percent ?? 0) : 0;
                @endphp
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                    <div class="bg-emerald-600 h-2.5 rounded-full" style="width: {{ $progress }}%;"></div>
                </div>
                <p class="text-xs text-gray-500">
                    {{ $progress }}% progres implementasi 7S.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Foto Before &amp; After</h2>
                </div>
                <p class="text-sm text-gray-600 mb-3">
                    Dokumentasi visual perubahan kondisi area sebelum dan sesudah penerapan 7S.
                </p>
                <div class="grid grid-cols-2 gap-3">
                    <div class="border rounded-lg overflow-hidden">
                        <div class="p-2 text-xs font-semibold text-gray-700">Before</div>
                        @if(isset($sevenS) && $sevenS && $sevenS->before_image)
                            <img src="{{ Storage::disk('public')->url($sevenS->before_image) }}" alt="Before 7S" class="w-full h-24 object-cover">
                        @else
                            <div class="w-full h-24 bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                                Belum ada foto
                            </div>
                        @endif
                        @auth
                            @if(Auth::user()->is_admin && isset($sevenS) && $sevenS && $sevenS->before_image)
                                <form action="{{ route('sevens.destroy') }}" method="POST" class="p-2 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="target" value="before_image">
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">Hapus Foto Before</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                    <div class="border rounded-lg overflow-hidden">
                        <div class="p-2 text-xs font-semibold text-gray-700">After</div>
                        @if(isset($sevenS) && $sevenS && $sevenS->after_image)
                            <img src="{{ Storage::disk('public')->url($sevenS->after_image) }}" alt="After 7S" class="w-full h-24 object-cover">
                        @else
                            <div class="w-full h-24 bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                                Belum ada foto
                            </div>
                        @endif
                        @auth
                            @if(Auth::user()->is_admin && isset($sevenS) && $sevenS && $sevenS->after_image)
                                <form action="{{ route('sevens.destroy') }}" method="POST" class="p-2 text-right">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="target" value="after_image">
                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">Hapus Foto After</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
                @auth
                    @if(Auth::user()->is_admin)
                        <form action="{{ route('sevens.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 border-t pt-4 space-y-3">
                            @csrf
                            <input type="hidden" name="section" value="photos">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-1">Ganti / Tambah Foto Before</label>
                                    <input type="file" name="before_image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="image/*">
                                    <p class="text-xs text-gray-500 mt-1">Format gambar: JPG, PNG. Maksimal ukuran file 5 MB.</p>
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-1">Ganti / Tambah Foto After</label>
                                    <input type="file" name="after_image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="image/*">
                                    <p class="text-xs text-gray-500 mt-1">Format gambar: JPG, PNG. Maksimal ukuran file 5 MB.</p>
                                </div>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2 px-4 rounded">Simpan Foto</button>
                            </div>
                        </form>
                    @endif
                @endauth
            </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Checklist 7S</h2>
                    @auth
                        @if(Auth::user()->is_admin)
                            <div class="flex flex-col items-end space-y-1 sm:flex-row sm:space-x-3 sm:space-y-0">
                                <button type="button" onclick="openSevenSChecklistModal()" class="text-xs text-emerald-700 hover:text-emerald-900 inline-flex items-center">
                                    <i class="fas fa-tasks mr-1"></i> Kelola checklist
                                </button>
                                <button type="button" onclick="openSevenSTextModal()" class="text-xs text-emerald-700 hover:text-emerald-900 inline-flex items-center">
                                    <i class="fas fa-pen mr-1"></i> Edit teks 7S
                                </button>
                            </div>
                        @endif
                    @endauth
                </div>
                <p class="text-sm text-gray-600 mb-3">
                    Ringkasan status penerapan setiap elemen 7S di laboratorium.
                </p>
                @php
                    $s = isset($sevenS) && $sevenS ? $sevenS : null;
                @endphp
                <div class="pr-1">
                    <ul class="grid sm:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-3 text-xs md:text-sm text-gray-700">
                        <li class="flex items-start space-x-2">
                            <input type="checkbox" {{ $s && $s->seiri ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                            <span>{{ $s && $s->seiri_text ? $s->seiri_text : 'Seiri (Sort) – pemilahan barang perlu dan tidak perlu.' }}</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <input type="checkbox" {{ $s && $s->seiton ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                            <span>{{ $s && $s->seiton_text ? $s->seiton_text : 'Seiton (Set in Order) – penataan peralatan dan bahan kerja.' }}</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <input type="checkbox" {{ $s && $s->seiso ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                            <span>{{ $s && $s->seiso_text ? $s->seiso_text : 'Seiso (Shine) – pembersihan rutin area kerja.' }}</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <input type="checkbox" {{ $s && $s->seiketsu ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                            <span>{{ $s && $s->seiketsu_text ? $s->seiketsu_text : 'Seiketsu (Standardize) – standarisasi tata letak dan label.' }}</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <input type="checkbox" {{ $s && $s->shitsuke ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                            <span>{{ $s && $s->shitsuke_text ? $s->shitsuke_text : 'Shitsuke (Sustain) – pembiasaan disiplin dan audit berkala.' }}</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <input type="checkbox" {{ $s && $s->safety_spirit ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                            <span>{{ $s && $s->safety_text ? $s->safety_text : 'Safety – aspek keselamatan di area kerja.' }}</span>
                        </li>
                        <li class="flex items-start space-x-2">
                            <input type="checkbox" {{ $s && $s->safety_spirit ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                            <span>{{ $s && $s->spirit_text ? $s->spirit_text : 'Spirit – budaya kerja positif dan kepedulian terhadap lingkungan kerja.' }}</span>
                        </li>
                    </ul>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Laporan Implementasi</h2>
                    @auth
                        @if(Auth::user()->is_admin)
                            <button type="button" onclick="openReportCreateModal()" class="text-xs text-emerald-700 hover:text-emerald-900 inline-flex items-center">
                                <i class="fas fa-plus mr-1"></i> Tambah laporan
                            </button>
                        @endif
                    @endauth
                </div>
                @if(isset($reports) && $reports->count())
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($reports as $report)
                            <div class="border rounded-lg p-3 space-y-2">
                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    <span>{{ $report->title ?: 'Laporan ' . $loop->iteration }}</span>
                                    <span>{{ $report->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="text-sm text-gray-700 whitespace-pre-line">
                                    {{ $report->content }}
                                </div>
                                @if($report->file_path)
                                    <div class="mt-1">
                                        <a href="{{ Storage::disk('public')->url($report->file_path) }}" target="_blank" class="inline-flex items-center text-emerald-700 hover:text-emerald-900 text-xs font-semibold">
                                            <i class="fas fa-file-alt mr-1"></i> Unduh Laporan
                                        </a>
                                    </div>
                                @endif
                                @auth
                                    @if(Auth::user()->is_admin)
                                        <div class="flex justify-end mt-2">
                                            <button type="button" onclick="openReportModal({{ $report->id }})" class="text-xs text-emerald-700 hover:text-emerald-900 inline-flex items-center">
                                                <i class="fas fa-edit mr-1"></i> Kelola laporan
                                            </button>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600">Belum ada laporan implementasi yang ditambahkan.</p>
                @endif
            </div>
        </div>
    </div>

    @auth
        @if(Auth::user()->is_admin)
            <div id="sevenSTextModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-2xl mx-4 p-6 shadow-2xl relative max-h-[80vh] overflow-y-auto">
                    <button type="button" onclick="closeSevenSTextModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Edit Teks Poin 7S</h3>
                    <form action="{{ route('sevens.store') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="hidden" name="section" value="labels">
                        @php
                            $s = isset($sevenS) && $sevenS ? $sevenS : null;
                        @endphp
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Teks Seiri</label>
                            <textarea name="seiri_text" rows="2" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $s && $s->seiri_text ? $s->seiri_text : 'Seiri (Sort) – pemilahan barang perlu dan tidak perlu.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Teks Seiton</label>
                            <textarea name="seiton_text" rows="2" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $s && $s->seiton_text ? $s->seiton_text : 'Seiton (Set in Order) – penataan peralatan dan bahan kerja.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Teks Seiso</label>
                            <textarea name="seiso_text" rows="2" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $s && $s->seiso_text ? $s->seiso_text : 'Seiso (Shine) – pembersihan rutin area kerja.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Teks Seiketsu</label>
                            <textarea name="seiketsu_text" rows="2" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $s && $s->seiketsu_text ? $s->seiketsu_text : 'Seiketsu (Standardize) – standarisasi tata letak dan label.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Teks Shitsuke</label>
                            <textarea name="shitsuke_text" rows="2" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $s && $s->shitsuke_text ? $s->shitsuke_text : 'Shitsuke (Sustain) – pembiasaan disiplin dan audit berkala.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Teks Safety</label>
                            <textarea name="safety_text" rows="2" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $s && $s->safety_text ? $s->safety_text : 'Safety – aspek keselamatan di area kerja.' }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-semibold mb-1">Teks Spirit</label>
                            <textarea name="spirit_text" rows="2" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $s && $s->spirit_text ? $s->spirit_text : 'Spirit – budaya kerja positif dan kepedulian terhadap lingkungan kerja.' }}</textarea>
                        </div>
                        <div class="mt-4 flex justify-end space-x-3">
                            <button type="button" onclick="closeSevenSTextModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-5 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="sevenSChecklistModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-lg mx-4 p-6 shadow-2xl relative max-h-[80vh] overflow-y-auto">
                    <button type="button" onclick="closeSevenSChecklistModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Kelola Checklist 7S</h3>
                    <form action="{{ route('sevens.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="section" value="checklist">
                        @php
                            $s = isset($sevenS) && $sevenS ? $sevenS : null;
                        @endphp
                        <div class="grid grid-cols-2 gap-3 text-sm">
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="seiri" value="1" {{ $s && $s->seiri ? 'checked' : '' }} class="rounded border-gray-300">
                                <span>Seiri</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="seiton" value="1" {{ $s && $s->seiton ? 'checked' : '' }} class="rounded border-gray-300">
                                <span>Seiton</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="seiso" value="1" {{ $s && $s->seiso ? 'checked' : '' }} class="rounded border-gray-300">
                                <span>Seiso</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="seiketsu" value="1" {{ $s && $s->seiketsu ? 'checked' : '' }} class="rounded border-gray-300">
                                <span>Seiketsu</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="shitsuke" value="1" {{ $s && $s->shitsuke ? 'checked' : '' }} class="rounded border-gray-300">
                                <span>Shitsuke</span>
                            </label>
                            <label class="flex items-center space-x-2">
                                <input type="checkbox" name="safety_spirit" value="1" {{ $s && $s->safety_spirit ? 'checked' : '' }} class="rounded border-gray-300">
                                <span>Safety &amp; Spirit</span>
                            </label>
                        </div>
                        <div class="flex justify-between items-center mt-4">
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded">Simpan Checklist</button>
                            <form action="{{ route('sevens.destroy') }}" method="POST" onsubmit="return confirm('Reset semua checklist 7S?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="target" value="checklist">
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800">Reset Checklist</button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>

            <div id="reportCreateModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-2xl mx-4 p-6 shadow-2xl relative max-h-[80vh] overflow-y-auto">
                    <button type="button" onclick="closeReportCreateModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Tambah Laporan 7S</h3>
                    <form action="{{ route('sevens.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <input type="hidden" name="section" value="report">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1">Judul Laporan</label>
                            <input type="text" name="title" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" placeholder="Misal: Audit 7S Mingguan">
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1">Isi Laporan</label>
                            <textarea name="report" rows="3" class="w-full border rounded px-3 py-2 focus:outline-emerald-500"></textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-1">Upload File (opsional)</label>
                            <input type="file" name="report_file" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept=".pdf,.doc,.docx">
                            <p class="text-xs text-gray-500 mt-1">Format: PDF, DOC, DOCX. Maksimal ukuran file 5 MB.</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            @php
                                $s = isset($sevenS) && $sevenS ? $sevenS : null;
                            @endphp
                            <input type="checkbox" name="published" value="1" {{ $s && $s->published ? 'checked' : '' }} class="rounded border-gray-300">
                            <span class="text-sm text-gray-700">Tampilkan ke publik</span>
                        </div>
                        <div class="flex justify-end space-x-3 mt-4">
                            <button type="button" onclick="closeReportCreateModal()" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-5 rounded">Tambah Laporan</button>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($reports) && $reports->count())
                @foreach($reports as $report)
                    <div id="reportModal-{{ $report->id }}" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                        <div class="bg-white rounded-lg w-full max-w-2xl mx-4 p-6 shadow-2xl relative max-h-[80vh] overflow-y-auto">
                            <button type="button" onclick="closeReportModal({{ $report->id }})" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                <i class="fas fa-times text-xl"></i>
                            </button>
                            <h3 class="text-xl font-bold mb-4 text-gray-800">Kelola Laporan</h3>
                            <form action="{{ route('sevens.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                @csrf
                                <input type="hidden" name="section" value="report">
                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-1">Judul Laporan</label>
                                    <input type="text" name="title" value="{{ $report->title }}" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-semibold mb-1">Isi Laporan</label>
                                    <textarea name="report" rows="3" class="w-full border rounded px-3 py-2 text-sm focus:outline-emerald-500">{{ $report->content }}</textarea>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div class="text-xs text-gray-600">
                                        @if($report->file_path)
                                            <a href="{{ Storage::disk('public')->url($report->file_path) }}" target="_blank" class="inline-flex items-center text-emerald-700 hover:text-emerald-900 font-semibold">
                                                <i class="fas fa-file-alt mr-1"></i> Lihat File
                                            </a>
                                        @else
                                            <span class="text-gray-400">Belum ada file laporan</span>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <label class="block text-gray-700 text-xs font-semibold mb-1">Ganti File</label>
                                        <input type="file" name="report_file" class="w-full border rounded px-2 py-1 text-xs focus:outline-emerald-500" accept=".pdf,.doc,.docx">
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 mt-2">
                                    <input type="checkbox" name="published" value="1" {{ $s && $s->published ? 'checked' : '' }} class="rounded border-gray-300">
                                    <span class="text-xs text-gray-700">Tampilkan ke publik</span>
                                </div>
                                <div class="flex justify-end space-x-3 mt-4">
                                    <button type="button" onclick="closeReportModal({{ $report->id }})" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Batal</button>
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded">Simpan</button>
                                </div>
                            </form>
                            <form action="{{ route('sevens.destroy') }}" method="POST" class="mt-4 text-right" onsubmit="return confirm('Hapus laporan ini?');">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="target" value="report">
                                <input type="hidden" name="report_id" value="{{ $report->id }}">
                                <button type="submit" class="text-xs text-red-600 hover:text-red-800">Hapus Laporan</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif

            <script>
                function openSevenSTextModal() {
                    var modal = document.getElementById('sevenSTextModal');
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                }
                function closeSevenSTextModal() {
                    var modal = document.getElementById('sevenSTextModal');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                }
                function openSevenSChecklistModal() {
                    var modal = document.getElementById('sevenSChecklistModal');
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                }
                function closeSevenSChecklistModal() {
                    var modal = document.getElementById('sevenSChecklistModal');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                }
                function openReportCreateModal() {
                    var modal = document.getElementById('reportCreateModal');
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                }
                function closeReportCreateModal() {
                    var modal = document.getElementById('reportCreateModal');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                }
                function openReportModal(id) {
                    var modal = document.getElementById('reportModal-' + id);
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                }
                function closeReportModal(id) {
                    var modal = document.getElementById('reportModal-' + id);
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                }
            </script>
        @endif
    @endauth
@endsection
