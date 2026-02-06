@extends('layouts.public')

@section('title', 'Flow Proses - Wilmar Nabati Indonesia')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Flow Proses Produksi</h2>
            <p class="text-gray-600 mt-2">Alur perjalanan dari sampel awal hingga menjadi produk akhir.</p>
        </div>
        @auth
            @if(Auth::user()->is_admin)
                <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow transition duration-200 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Tambah Proses
                </button>
            @endif
        @endauth
    </div>

    <!-- Timeline / Process Flow -->
    <div class="relative border-l-4 border-emerald-500 ml-3 md:ml-6 space-y-12">
        @forelse($flows as $index => $flow)
            <div class="relative pl-8 md:pl-12 group">
                <!-- Dot -->
                <div class="absolute -left-3 top-0 bg-emerald-500 h-6 w-6 rounded-full border-4 border-white shadow"></div>
                
                <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-300">
                    <div class="flex flex-col md:flex-row gap-6">
                        @if($flow->image)
                        <div class="w-full md:w-1/3">
                            <img src="{{ Storage::disk('public')->url($flow->image) }}" alt="{{ $flow->step_name }}" class="w-full h-48 object-cover rounded-lg">
                        </div>
                    @endif
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $flow->step_name }}</h3>
                                @auth
                                    @if(Auth::user()->is_admin)
                                        <div class="flex space-x-2">
                                            <button 
                                                data-id="{{ $flow->id }}"
                                                data-step_name="{{ $flow->step_name }}"
                                                data-order="{{ $flow->order }}"
                                                data-description="{{ $flow->description }}"
                                                data-url="{{ route('flow.update', $flow->id) }}"
                                                onclick="openEditFlowModal(this)" 
                                                class="text-yellow-500 hover:text-yellow-700">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('flow.destroy', $flow->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus proses ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                            <span class="inline-block bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full mb-3">Langkah {{ $flow->order ?? $index + 1 }}</span>
                            <p class="text-gray-600 leading-relaxed">{{ $flow->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="pl-8 md:pl-12">
                <div class="border border-dashed rounded-lg p-8 text-center">
                    <i class="fas fa-industry text-3xl text-gray-400 mb-2"></i>
                    <div class="font-semibold text-gray-700">Belum ada Flow Proses Produksi</div>
                    <div class="text-sm text-gray-500">Tambahkan tahapan proses untuk ditampilkan di sini.</div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Modal Form (Hidden by default) -->
    @auth
        @if(Auth::user()->is_admin)
            <div id="addModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-2xl mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('addModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Tambah Proses Baru</h3>
                    
                    <form action="{{ route('flow.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Tahapan</label>
                                <input type="text" name="step_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-emerald-500" placeholder="Contoh: Sampel Awal" required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Urutan (Angka)</label>
                                <input type="number" name="order" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="0">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                <textarea name="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Jelaskan proses ini..."></textarea>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Gambar Ilustrasi</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG. Max 2MB.</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endauth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.location.hash === '#add') {
                var modal = document.getElementById('addModal');
                if (modal) modal.classList.remove('hidden');
            }
        });
    </script>

    <!-- Edit Modal -->
    @auth
        @if(Auth::user()->is_admin)
            <div id="editFlowModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-2xl mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editFlowModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-2xl font-bold mb-6 text-gray-800 border-b pb-2">Edit Proses</h3>
                    
                    <form id="editFlowForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Tahapan</label>
                                <input type="text" id="edit_step_name" name="step_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-emerald-500" required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Urutan (Angka)</label>
                                <input type="number" id="edit_order" name="order" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                <textarea id="edit_description" name="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            </div>

                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Ganti Gambar (Opsional)</label>
                                <input type="file" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editFlowModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function openEditFlowModal(button) {
                    const id = button.getAttribute('data-id');
                    const step_name = button.getAttribute('data-step_name');
                    const order = button.getAttribute('data-order');
                    const description = button.getAttribute('data-description');
                    const url = button.getAttribute('data-url');

                    const form = document.getElementById('editFlowForm');
                    form.action = url;
                    
                    document.getElementById('edit_step_name').value = step_name;
                    document.getElementById('edit_order').value = order;
                    document.getElementById('edit_description').value = description || '';
                    
                    document.getElementById('editFlowModal').classList.remove('hidden');
                }
            </script>
        @endif
    @endauth

@endsection
