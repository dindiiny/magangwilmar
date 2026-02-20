@extends('layouts.public')

@section('title', 'House Keeping - Wilmar Nabati Indonesia')

@section('content')
    <div class="max-w-6xl mx-auto space-y-6">
        <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 mb-1">House Keeping Laboratorium</h1>
                <p class="text-gray-600 text-sm">
                    Jadwal rutin cleaning area laboratorium dan dokumentasi kegiatan House Keeping.
                </p>
            </div>
            @auth
                @if(Auth::user()->is_admin)
                    <button onclick="document.getElementById('hkModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold py-2 px-4 rounded shadow flex items-center">
                        <i class="fas fa-edit mr-2"></i> Kelola House Keeping
                    </button>
                @endif
            @endauth
        </div>

        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Schedule Cleaning Mingguan</h2>
                <p class="text-sm text-gray-600 mb-3">
                    Rencana kegiatan House Keeping per minggu untuk menjaga kebersihan dan kerapian laboratorium.
                </p>
                @php
                    $hk = isset($houseKeeping) && $houseKeeping ? $houseKeeping : null;
                @endphp
                @if($hk && $hk->weekly_schedule)
                    <div class="text-sm text-gray-800 whitespace-pre-line">
                        {{ $hk->weekly_schedule }}
                    </div>
                @else
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Senin: Pembersihan meja kerja, timbangan, dan alat ukur.</li>
                        <li>Rabu: Pengecekan dan pembersihan area penyimpanan bahan kimia.</li>
                        <li>Jumat: General cleaning area laboratorium dan pemeriksaan alat.</li>
                        <li>Minggu ke-1: Deep cleaning dan penataan ulang label.</li>
                    </ul>
                @endif
            </div>

            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-3">Area Cleaning</h2>
                <p class="text-sm text-gray-600 mb-3">
                    Area-area yang menjadi fokus kegiatan cleaning dan house keeping.
                </p>
                @if($hk && $hk->areas)
                    <div class="text-sm text-gray-800 whitespace-pre-line">
                        {{ $hk->areas }}
                    </div>
                @else
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Meja kerja analisa dan preparation.</li>
                        <li>Area timbangan dan instrumen sensitif.</li>
                        <li>Rak penyimpanan bahan kimia dan glassware.</li>
                        <li>Area pembuangan limbah sementara.</li>
                        <li>Koridor dan akses masuk laboratorium.</li>
                    </ul>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-3">Video House Keeping</h2>
            <p class="text-sm text-gray-600 mb-4">
                Dokumentasi video kegiatan house keeping sebagai bukti pelaksanaan dan bahan edukasi.
            </p>
            @if($hk && $hk->video_path)
                <div class="aspect-video w-full bg-black rounded-lg overflow-hidden">
                    <video class="w-full h-full" controls>
                        <source src="{{ Storage::disk('public')->url($hk->video_path) }}" type="video/mp4">
                        Browser Anda tidak mendukung pemutaran video.
                    </video>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Jika video tidak muncul, pastikan format file kompatibel (MP4 disarankan).
                </p>
            @else
                <div class="border border-dashed border-gray-300 rounded-lg p-6 text-center text-sm text-gray-500">
                    Belum ada video House Keeping yang diunggah.
                </div>
            @endif
        </div>
    </div>

    @auth
        @if(Auth::user()->is_admin)
            <div id="hkModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-2xl mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('hkModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Kelola House Keeping</h3>
                    <form action="{{ route('housekeeping.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Schedule Cleaning Mingguan</label>
                                <textarea name="weekly_schedule" rows="5" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" placeholder="Contoh:
Senin: ...
Rabu: ...
Jumat: ...
Minggu ke-1: ...">{{ $hk ? $hk->weekly_schedule : '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Area Cleaning</label>
                                <textarea name="areas" rows="4" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" placeholder="Daftar area yang dibersihkan">{{ $hk ? $hk->areas : '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Video House Keeping</label>
                                <input type="file" name="video" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="video/*">
                                <p class="text-xs text-gray-500 mt-1">
                                    Format disarankan: MP4. Maksimal 50 MB.
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="published" value="1" {{ $hk && $hk->published ? 'checked' : '' }} class="rounded border-gray-300">
                                <span class="text-sm text-gray-700">Tampilkan ke publik</span>
                            </div>
                        </div>
                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('hkModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth
@endsection

