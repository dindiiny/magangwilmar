@extends('layouts.public')

@section('title', 'Laboratorium - Wilmar Nabati Indonesia')

@section('content')
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <div class="lg:col-span-3">
            <div x-data="{ activeTab: 'peralatan' }">
        <!-- Tabs Navigation -->
        <div class="flex space-x-1 bg-white p-1 rounded-lg shadow mb-6 overflow-x-auto">
            <button @click="activeTab = 'peralatan'" :class="{ 'bg-emerald-600 text-white shadow': activeTab === 'peralatan', 'text-gray-600 hover:bg-gray-100': activeTab !== 'peralatan' }" class="flex-1 py-2 px-4 rounded-md font-medium transition duration-200 whitespace-nowrap">
                Peralatan Labor
            </button>
            <button @click="activeTab = 'produk'" :class="{ 'bg-emerald-600 text-white shadow': activeTab === 'produk', 'text-gray-600 hover:bg-gray-100': activeTab !== 'produk' }" class="flex-1 py-2 px-4 rounded-md font-medium transition duration-200 whitespace-nowrap">
                Jenis Produk
            </button>
            <button @click="activeTab = 'sop'" :class="{ 'bg-emerald-600 text-white shadow': activeTab === 'sop', 'text-gray-600 hover:bg-gray-100': activeTab !== 'sop' }" class="flex-1 py-2 px-4 rounded-md font-medium transition duration-200 whitespace-nowrap">
                SOP Pengujian
            </button>
        </div>

        <!-- Tab Content: Peralatan -->
        <div x-show="activeTab === 'peralatan'" class="space-y-8" style="display: none;">
            <!-- Instrument Section -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 border-l-4 border-emerald-500 pl-3">Instrument</h3>
                    @auth
                        @if(Auth::user()->is_admin)
                            <button onclick="openModal('instrument')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Instrument
                            </button>
                        @endif
                    @endauth
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($instruments as $item)
                        <div class="bg-white rounded-lg shadow overflow-hidden group relative">
                            @if($item->image)
                                <img src="{{ Storage::disk('public')->url($item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-microscope text-4xl"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800">{{ $item->name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
                            </div>
                            @auth
                                @if(Auth::user()->is_admin)
                                    <div class="absolute top-2 right-2 hidden group-hover:flex space-x-1">
                                        <button 
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"
                                            data-category="{{ $item->category }}"
                                            data-description="{{ $item->description }}"
                                            data-url="{{ route('equipment.update', $item->id) }}"
                                            onclick="openEditEquipmentModal(this)" 
                                            class="bg-yellow-500 text-white p-2 rounded-full shadow hover:bg-yellow-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('equipment.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                            @csrf @method('DELETE')
                                            <button class="bg-red-500 text-white p-2 rounded-full shadow hover:bg-red-600"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-3">
                            <div class="border border-dashed rounded-lg p-8 text-center">
                                <i class="fas fa-microscope text-3xl text-gray-400 mb-2"></i>
                                <div class="font-semibold text-gray-700">Belum ada Instrument</div>
                                <div class="text-sm text-gray-500">Tambahkan instrument untuk ditampilkan di sini.</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Glassware Section -->
            <div>
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800 border-l-4 border-emerald-500 pl-3">Glassware</h3>
                    @auth
                        @if(Auth::user()->is_admin)
                            <button onclick="openModal('glassware')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                                <i class="fas fa-plus mr-1"></i> Tambah Glassware
                            </button>
                        @endif
                    @endauth
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($glassware as $item)
                        <div class="bg-white rounded-lg shadow overflow-hidden group relative">
                            @if($item->image)
                                <img src="{{ Storage::disk('public')->url($item->image) }}" alt="{{ $item->name }}" class="w-full h-48 object-cover">
                            @else
                                <div class="h-48 bg-gray-200 flex items-center justify-center text-gray-400">
                                    <i class="fas fa-flask text-4xl"></i>
                                </div>
                            @endif
                            <div class="p-4">
                                <h4 class="font-bold text-gray-800">{{ $item->name }}</h4>
                                <p class="text-sm text-gray-600 mt-1">{{ $item->description }}</p>
                            </div>
                            @auth
                                @if(Auth::user()->is_admin)
                                    <div class="absolute top-2 right-2 hidden group-hover:flex space-x-1">
                                        <button 
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"
                                            data-category="{{ $item->category }}"
                                            data-description="{{ $item->description }}"
                                            data-url="{{ route('equipment.update', $item->id) }}"
                                            onclick="openEditEquipmentModal(this)" 
                                            class="bg-yellow-500 text-white p-2 rounded-full shadow hover:bg-yellow-600">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('equipment.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus?');">
                                            @csrf @method('DELETE')
                                            <button class="bg-red-500 text-white p-2 rounded-full shadow hover:bg-red-600"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-3">
                            <div class="border border-dashed rounded-lg p-8 text-center">
                                <i class="fas fa-flask text-3xl text-gray-400 mb-2"></i>
                                <div class="font-semibold text-gray-700">Belum ada Glassware</div>
                                <div class="text-sm text-gray-500">Tambahkan glassware untuk ditampilkan di sini.</div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Tab Content: Produk -->
        <div x-show="activeTab === 'produk'" style="display: none;">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Jenis Produk & Keterangan</h3>
                @auth
                    @if(Auth::user()->is_admin)
                        <button onclick="document.getElementById('addProductModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Produk
                        </button>
                    @endif
                @endauth
            </div>
            
            <div class="space-y-6">
                @forelse($products as $product)
                    <div class="bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row gap-6 group relative">
                        @if($product->image)
                            <div class="w-full md:w-48 h-48 flex-shrink-0">
                                <img src="{{ Storage::disk('public')->url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h4>
                            <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                        </div>
                        
                        @auth
                            @if(Auth::user()->is_admin)
                                <div class="absolute top-4 right-4 hidden group-hover:flex space-x-2">
                                    <button 
                                        data-id="{{ $product->id }}"
                                        data-name="{{ $product->name }}"
                                        data-description="{{ $product->description }}"
                                        data-url="{{ route('product.update', $product->id) }}"
                                        onclick="openEditProductModal(this)" 
                                        class="text-yellow-500 hover:text-yellow-700">
                                        <i class="fas fa-edit fa-lg"></i>
                                    </button>
                                    <form action="{{ route('product.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash fa-lg"></i></button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @empty
                    <div class="border border-dashed rounded-lg p-8 text-center">
                        <i class="fas fa-box-open text-3xl text-gray-400 mb-2"></i>
                        <div class="font-semibold text-gray-700">Belum ada Produk</div>
                        <div class="text-sm text-gray-500">Tambahkan produk untuk ditampilkan di sini.</div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Content: SOP Pengujian -->
        <div x-show="activeTab === 'sop'" style="display: none;">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-gray-800">SOP Pengujian</h3>
                @auth
                    @if(Auth::user()->is_admin)
                        <button onclick="document.getElementById('addSOPModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah SOP
                        </button>
                    @endif
                @endauth
            </div>
            
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-r border-gray-200 bg-emerald-900 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Parameter
                            </th>
                            <th class="px-5 py-3 border-b-2 border-r border-gray-200 bg-emerald-900 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                Metode
                            </th>
                            @auth
                                @if(Auth::user()->is_admin)
                                    <th class="px-5 py-3 border-b-2 border-gray-200 bg-emerald-900 text-left text-xs font-semibold text-white uppercase tracking-wider">
                                        Aksi
                                    </th>
                                @endif
                            @endauth
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sops as $sop)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                    <p class="text-gray-900 whitespace-no-wrap font-bold">{{ $sop->parameter }}</p>
                                </td>
                                <td class="px-5 py-5 border-b border-r border-gray-200 bg-white text-sm">
                                    <p class="text-gray-700 whitespace-no-wrap">{{ $sop->metode }}</p>
                                </td>
                                @auth
                                    @if(Auth::user()->is_admin)
                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex space-x-2">
                                                <button 
                                            data-id="{{ $sop->id }}"
                                            data-parameter="{{ $sop->parameter }}"
                                            data-metode="{{ $sop->metode }}"
                                            data-url="{{ route('sop.update', $sop->id) }}"
                                            onclick="openEditSOPModal(this)" 
                                            class="text-yellow-500 hover:text-yellow-700">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                                <form action="{{ route('sop.destroy', $sop->id) }}" method="POST" onsubmit="return confirm('Hapus SOP ini?');">
                                                    @csrf @method('DELETE')
                                                    <button class="text-red-500 hover:text-red-700"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                @endauth
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                    Belum ada data SOP.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </div>
        </div>

        <aside class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-lg shadow p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-1">Kegiatan 7S Laboratorium</h3>
                <p class="text-sm text-gray-600">
                    Ringkasan penerapan 7S di area laboratorium yang dapat diakses publik.
                </p>
            </div>

            <div class="bg-white rounded-lg shadow p-4">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-semibold text-gray-800 text-sm uppercase tracking-wide">Progress Improvement</h4>
                    @auth
                        @if(Auth::user()->is_admin)
                            <button onclick="document.getElementById('sevenSModal').classList.remove('hidden')" class="text-xs bg-emerald-600 text-white px-2 py-1 rounded">
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

            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-3">Foto Before &amp; After</h4>
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

            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-3">Checklist 7S</h4>
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

            <div class="bg-white rounded-lg shadow p-4">
                <h4 class="font-semibold text-gray-800 text-sm uppercase tracking-wide mb-3">Laporan Implementasi</h4>
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
                @elseif(!$s || (!$s->report && !$s->report_file))
                    <ul class="list-disc list-inside text-sm text-gray-700 space-y-1">
                        <li>Hasil audit area laboratorium.</li>
                        <li>Rencana aksi perbaikan dan jadwal pelaksanaan.</li>
                        <li>Catatan sebelum dan sesudah perbaikan.</li>
                    </ul>
                @endif
            </div>
        </aside>
    </div>

    <!-- Modals -->
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
    @auth
        @if(Auth::user()->is_admin)
            <!-- Add Equipment Modal -->
            <div id="equipmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('equipmentModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 id="equipmentModalTitle" class="text-xl font-bold mb-4 text-gray-800">Tambah Peralatan</h3>
                    
                    <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="category" id="equipmentCategoryInput">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Nama Alat</label>
                                <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi</label>
                                <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Foto Produk</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="image/*">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('equipmentModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Equipment Modal -->
            <div id="editEquipmentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editEquipmentModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Edit Peralatan</h3>
                    
                    <form id="editEquipmentForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="category" id="editEquipmentCategory">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Nama Alat</label>
                                <input type="text" id="editEquipmentName" name="name" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi</label>
                                <textarea id="editEquipmentDescription" name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Ganti Gambar (Opsional)</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editEquipmentModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add Product Modal -->
            <div id="addProductModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('addProductModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Tambah Produk</h3>
                    
                    <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Nama Produk</label>
                                <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi</label>
                                <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Gambar</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('addProductModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Product Modal -->
            <div id="editProductModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editProductModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Edit Produk</h3>
                    
                    <form id="editProductForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Nama Produk</label>
                                <input type="text" id="editProductName" name="name" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi</label>
                                <textarea id="editProductDescription" name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Ganti Gambar (Opsional)</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editProductModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Add SOP Modal -->
            <div id="addSOPModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('addSOPModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Tambah SOP Pengujian</h3>
                    
                    <form action="{{ route('sop.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Parameter</label>
                                <input type="text" name="parameter" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Metode</label>
                                <input type="text" name="metode" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('addSOPModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit SOP Modal -->
            <div id="editSOPModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editSOPModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Edit SOP Pengujian</h3>
                    
                    <form id="editSOPForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Parameter</label>
                                <input type="text" id="editSOPParameter" name="parameter" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Metode</label>
                                <input type="text" id="editSOPMetode" name="metode" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editSOPModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function openModal(category) {
                    document.getElementById('equipmentCategoryInput').value = category;
                    document.getElementById('equipmentModalTitle').innerText = 'Tambah ' + (category === 'instrument' ? 'Instrument' : 'Glassware');
                    document.getElementById('equipmentModal').classList.remove('hidden');
                }

                function openEditEquipmentModal(button) {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');
                    const category = button.getAttribute('data-category');
                    const description = button.getAttribute('data-description');
                    const url = button.getAttribute('data-url');

                    const form = document.getElementById('editEquipmentForm');
                    form.action = url;
                    
                    document.getElementById('editEquipmentName').value = name;
                    document.getElementById('editEquipmentCategory').value = category;
                    document.getElementById('editEquipmentDescription').value = description || '';
                    
                    document.getElementById('editEquipmentModal').classList.remove('hidden');
                }

                function openEditProductModal(button) {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');
                    const description = button.getAttribute('data-description');
                    const url = button.getAttribute('data-url');

                    const form = document.getElementById('editProductForm');
                    form.action = url;
                    
                    document.getElementById('editProductName').value = name;
                    document.getElementById('editProductDescription').value = description || '';
                    
                    document.getElementById('editProductModal').classList.remove('hidden');
                }

                function openEditSOPModal(button) {
                    const id = button.getAttribute('data-id');
                    const parameter = button.getAttribute('data-parameter');
                    const metode = button.getAttribute('data-metode');
                    const url = button.getAttribute('data-url');

                    const form = document.getElementById('editSOPForm');
                    form.action = url;
                    
                    document.getElementById('editSOPParameter').value = parameter;
                    document.getElementById('editSOPMetode').value = metode;
                    
                    document.getElementById('editSOPModal').classList.remove('hidden');
                }
            </script>
        @endif
    @endauth

    <!-- Alpine.js for Tabs (Since I used x-data above) -->
    <script src="//unpkg.com/alpinejs" defer></script>
@endsection
