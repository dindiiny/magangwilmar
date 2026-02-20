@extends('layouts.public')

@section('title', 'Kegiatan 7S - Wilmar Nabati Indonesia')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Kegiatan 7S Laboratorium</h1>
            <p class="text-gray-600">
                Ringkasan penerapan 7S di area laboratorium yang dapat diakses publik.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Progress Improvement</h2>
                    @auth
                        @if(Auth::user()->is_admin)
                            <button onclick="document.getElementById('sevenSModal').classList.remove('hidden')" class="text-xs bg-emerald-600 text-white px-3 py-1 rounded">
                                Kelola
                            </button>
                        @endif
                    @endauth
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
                <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-3">Foto Before &amp; After</h2>
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
                    </div>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-3">Checklist 7S</h2>
                <p class="text-sm text-gray-600 mb-3">
                    Ringkasan status penerapan setiap elemen 7S di laboratorium.
                </p>
                @php
                    $s = isset($sevenS) && $sevenS ? $sevenS : null;
                @endphp
                <ul class="space-y-2 text-sm text-gray-700">
                    <li class="flex items-start space-x-2">
                        <input type="checkbox" {{ $s && $s->seiri ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                        <span>Seiri (Sort) – pemilahan barang perlu dan tidak perlu.</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <input type="checkbox" {{ $s && $s->seiton ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                        <span>Seiton (Set in Order) – penataan peralatan dan bahan kerja.</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <input type="checkbox" {{ $s && $s->seiso ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                        <span>Seiso (Shine) – pembersihan rutin area kerja.</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <input type="checkbox" {{ $s && $s->seiketsu ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                        <span>Seiketsu (Standardize) – standarisasi tata letak dan label.</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <input type="checkbox" {{ $s && $s->shitsuke ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                        <span>Shitsuke (Sustain) – pembiasaan disiplin dan audit berkala.</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <input type="checkbox" {{ $s && $s->safety_spirit ? 'checked' : '' }} class="mt-0.5 text-emerald-600 rounded border-gray-300" disabled>
                        <span>Safety &amp; Spirit – aspek keselamatan dan budaya kerja positif.</span>
                    </li>
                </ul>
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-3">Laporan Implementasi</h2>
                <p class="text-sm text-gray-600 mb-3">
                    Ringkasan laporan pelaksanaan 7S, termasuk temuan, rekomendasi, dan tindak lanjut.
                </p>
                @if($s && $s->report)
                    <div class="text-sm text-gray-700 whitespace-pre-line">
                        {{ $s->report }}
                    </div>
                @endif
                @if($s && $s->report_file)
                    <div class="mt-2">
                        <a href="{{ Storage::disk('public')->url($s->report_file) }}" target="_blank" class="inline-flex items-center text-emerald-700 hover:text-emerald-900 text-sm font-semibold">
                            <i class="fas fa-file-alt mr-2"></i> Unduh Laporan Implementasi
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @auth
        @if(Auth::user()->is_admin)
            <div id="sevenSModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('sevenSModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Kelola Data 7S</h3>
                    <form action="{{ route('sevens.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div class="text-sm text-gray-600 bg-emerald-50 border border-emerald-200 rounded p-3">
                                Progress dihitung otomatis dari checklist 7S, foto before/after, dan laporan.
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-1">Foto Before</label>
                                    <input type="file" name="before_image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="image/*">
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-1">Foto After</label>
                                    <input type="file" name="after_image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="image/*">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Checklist 7S</label>
                                <div class="grid grid-cols-2 gap-2 text-sm">
                                    <label class="flex items-center space-x-2"><input type="checkbox" name="seiri" value="1" {{ $s && $s->seiri ? 'checked' : '' }} class="rounded border-gray-300"><span>Seiri</span></label>
                                    <label class="flex items-center space-x-2"><input type="checkbox" name="seiton" value="1" {{ $s && $s->seiton ? 'checked' : '' }} class="rounded border-gray-300"><span>Seiton</span></label>
                                    <label class="flex items-center space-x-2"><input type="checkbox" name="seiso" value="1" {{ $s && $s->seiso ? 'checked' : '' }} class="rounded border-gray-300"><span>Seiso</span></label>
                                    <label class="flex items-center space-x-2"><input type="checkbox" name="seiketsu" value="1" {{ $s && $s->seiketsu ? 'checked' : '' }} class="rounded border-gray-300"><span>Seiketsu</span></label>
                                    <label class="flex items-center space-x-2"><input type="checkbox" name="shitsuke" value="1" {{ $s && $s->shitsuke ? 'checked' : '' }} class="rounded border-gray-300"><span>Shitsuke</span></label>
                                    <label class="flex items-center space-x-2"><input type="checkbox" name="safety_spirit" value="1" {{ $s && $s->safety_spirit ? 'checked' : '' }} class="rounded border-gray-300"><span>Safety &amp; Spirit</span></label>
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Laporan Implementasi</label>
                                <textarea name="report" rows="4" class="w-full border rounded px-3 py-2 focus:outline-emerald-500">{{ $s ? $s->report : '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Upload File Laporan</label>
                                <input type="file" name="report_file" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept=".pdf,.doc,.docx">
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="published" value="1" {{ $s && $s->published ? 'checked' : '' }} class="rounded border-gray-300">
                                <span class="text-sm text-gray-700">Tampilkan ke publik</span>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('sevenSModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth
@endsection
