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

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between mb-3">
                <h2 class="text-lg font-semibold text-gray-800">Riwayat House Keeping</h2>
                @auth
                    @if(Auth::user()->is_admin)
                        <button onclick="openHouseKeepingModal()" class="bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-2 px-3 rounded shadow flex items-center">
                            <i class="fas fa-plus mr-1"></i> Tambah Log
                        </button>
                    @endif
                @endauth
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Daftar kegiatan cleaning per hari beserta area dan dokumentasi videonya.
            </p>
            @php
                $logs = isset($logs) ? $logs : collect();
            @endphp
            @if($logs->isEmpty())
                <div class="border border-dashed border-gray-300 rounded-lg p-6 text-center text-sm text-gray-500">
                    Belum ada data House Keeping yang tersimpan.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm text-left text-gray-700">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2 pr-4">Tanggal</th>
                                <th class="py-2 pr-4">Hari</th>
                                <th class="py-2 pr-4">Area</th>
                                <th class="py-2 pr-4">Kegiatan</th>
                                <th class="py-2 pr-4">Video</th>
                                @auth
                                    @if(Auth::user()->is_admin)
                                        <th class="py-2 pr-4 text-right">Aksi</th>
                                    @endif
                                @endauth
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                                <tr class="border-b align-top">
                                    <td class="py-2 pr-4 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($log->date)->format('d-m-Y') }}
                                    </td>
                                    <td class="py-2 pr-4 whitespace-nowrap">
                                        {{ $log->day_name }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $log->areas ?: '-' }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        {{ $log->activities ?: '-' }}
                                    </td>
                                    <td class="py-2 pr-4">
                                        @if($log->video_path)
                                            <a href="{{ Storage::disk('public')->url($log->video_path) }}" target="_blank" class="inline-flex items-center text-emerald-700 hover:text-emerald-900">
                                                <i class="fas fa-play-circle mr-1"></i> Lihat Video
                                            </a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    @auth
                                        @if(Auth::user()->is_admin)
                                            <td class="py-2 pr-4 text-right whitespace-nowrap">
                                                <button type="button"
                                                    onclick="editHouseKeepingLog(this)"
                                                    data-id="{{ $log->id }}"
                                                    data-date="{{ $log->date }}"
                                                    data-day="{{ $log->day_name }}"
                                                    data-areas="{{ $log->areas }}"
                                                    data-activities="{{ $log->activities }}"
                                                    data-published="{{ $log->published ? '1' : '0' }}"
                                                    class="text-xs text-emerald-700 hover:text-emerald-900 mr-3">
                                                    <i class="fas fa-edit mr-1"></i> Edit
                                                </button>
                                                <form action="{{ route('housekeeping.destroy', $log->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus log House Keeping ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-xs text-red-600 hover:text-red-800">
                                                        <i class="fas fa-trash mr-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        @endif
                                    @endauth
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                    <h3 class="text-2xl font-bold mb-4 text-gray-800" id="hkModalTitle">Tambah / Ubah Log House Keeping</h3>
                    <form action="{{ route('housekeeping.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Tanggal</label>
                                <input type="date" name="date" id="hkDate" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Hari</label>
                                <select name="day_name" id="hkDay" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                                    <option value="">Pilih hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Area Cleaning</label>
                                <textarea name="areas" id="hkAreas" rows="3" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" placeholder="Area yang dibersihkan pada hari tersebut"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Kegiatan House Keeping</label>
                                <textarea name="activities" id="hkActivities" rows="3" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" placeholder="Uraian kegiatan cleaning pada hari tersebut"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Video House Keeping (Opsional)</label>
                                <input type="file" name="video" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="video/*">
                                <p class="text-xs text-gray-500 mt-1">
                                    Format disarankan: MP4. Maksimal ukuran file 5 MB.
                                </p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <input type="checkbox" name="published" id="hkPublished" value="1" checked class="rounded border-gray-300">
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
            <script>
                function openHouseKeepingModal() {
                    var form = document.querySelector('#hkModal form');
                    if (form) {
                        form.reset();
                    }
                    var dateInput = document.getElementById('hkDate');
                    var daySelect = document.getElementById('hkDay');
                    var published = document.getElementById('hkPublished');
                    if (published) {
                        published.checked = true;
                    }
                    var title = document.getElementById('hkModalTitle');
                    if (title) {
                        title.textContent = 'Tambah Log House Keeping';
                    }
                    var modal = document.getElementById('hkModal');
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                }

                function editHouseKeepingLog(button) {
                    var id = button.getAttribute('data-id');
                    var date = button.getAttribute('data-date');
                    var day = button.getAttribute('data-day');
                    var areas = button.getAttribute('data-areas') || '';
                    var activities = button.getAttribute('data-activities') || '';
                    var published = button.getAttribute('data-published') === '1';

                    var dateInput = document.getElementById('hkDate');
                    var daySelect = document.getElementById('hkDay');
                    var areasInput = document.getElementById('hkAreas');
                    var activitiesInput = document.getElementById('hkActivities');
                    var publishedInput = document.getElementById('hkPublished');
                    var title = document.getElementById('hkModalTitle');

                    if (dateInput) dateInput.value = date;
                    if (daySelect) daySelect.value = day;
                    if (areasInput) areasInput.value = areas;
                    if (activitiesInput) activitiesInput.value = activities;
                    if (publishedInput) publishedInput.checked = published;
                    if (title) title.textContent = 'Edit Log House Keeping';

                    var modal = document.getElementById('hkModal');
                    if (modal) {
                        modal.classList.remove('hidden');
                    }
                }
            </script>
        @endif
    @endauth
@endsection
