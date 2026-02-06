@extends('layouts.public')

@section('title', 'Laporan & Dokumen - Wilmar Nabati Indonesia')

@section('content')
    <div x-data="{ activeTab: 'coa' }">
        <!-- Tabs Navigation -->
        <div class="flex space-x-1 bg-white p-1 rounded-lg shadow mb-6 overflow-x-auto">
            <button @click="activeTab = 'coa'" :class="{ 'bg-emerald-600 text-white shadow': activeTab === 'coa', 'text-gray-600 hover:bg-gray-100': activeTab !== 'coa' }" class="flex-1 py-2 px-4 rounded-md font-medium transition duration-200 whitespace-nowrap">
                COA (Certificate of Analysis)
            </button>
            <button @click="activeTab = 'incoming'" :class="{ 'bg-emerald-600 text-white shadow': activeTab === 'incoming', 'text-gray-600 hover:bg-gray-100': activeTab !== 'incoming' }" class="flex-1 py-2 px-4 rounded-md font-medium transition duration-200 whitespace-nowrap">
                Incoming Material
            </button>
            <button @click="activeTab = 'msds'" :class="{ 'bg-emerald-600 text-white shadow': activeTab === 'msds', 'text-gray-600 hover:bg-gray-100': activeTab !== 'msds' }" class="flex-1 py-2 px-4 rounded-md font-medium transition duration-200 whitespace-nowrap">
                MSDS Chemical
            </button>
        </div>

        <!-- Tab Content: COA -->
        <div x-show="activeTab === 'coa'" class="space-y-6">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 border-l-4 border-emerald-500 pl-3 mb-2">Certificate of Analysis</h3>
                    <p class="text-gray-600 text-sm ml-4">Dokumen yang menyatakan hasil pengujian kualitas produk untuk memastikan kesesuaian dengan spesifikasi standar.</p>
                </div>
                @auth
                    @if(Auth::user()->is_admin)
                        <button onclick="openModal('coa')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm whitespace-nowrap">
                            <i class="fas fa-plus mr-1"></i> Tambah Dokumen
                        </button>
                    @endif
                @endauth
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($coas as $doc)
                    @include('components.document-card', ['doc' => $doc])
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3">
                        <div class="border border-dashed rounded-lg p-8 text-center">
                            <i class="fas fa-file-pdf text-3xl text-gray-400 mb-2"></i>
                            <div class="font-semibold text-gray-700">Belum ada dokumen COA</div>
                            <div class="text-sm text-gray-500">Unggah dokumen COA untuk ditampilkan di sini.</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Content: Incoming -->
        <div x-show="activeTab === 'incoming'" class="space-y-6" style="display: none;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 border-l-4 border-emerald-500 pl-3 mb-2">Incoming Material</h3>
                    <p class="text-gray-600 text-sm ml-4">Laporan pemeriksaan kualitas bahan baku yang masuk sebelum diproses lebih lanjut.</p>
                </div>
                @auth
                    @if(Auth::user()->is_admin)
                        <button onclick="openModal('incoming')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm whitespace-nowrap">
                            <i class="fas fa-plus mr-1"></i> Tambah Dokumen
                        </button>
                    @endif
                @endauth
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($incomings as $doc)
                    @include('components.document-card', ['doc' => $doc])
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3">
                        <div class="border border-dashed rounded-lg p-8 text-center">
                            <i class="fas fa-file-alt text-3xl text-gray-400 mb-2"></i>
                            <div class="font-semibold text-gray-700">Belum ada dokumen Incoming Material</div>
                            <div class="text-sm text-gray-500">Unggah laporan incoming untuk ditampilkan di sini.</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Tab Content: MSDS -->
        <div x-show="activeTab === 'msds'" class="space-y-6" style="display: none;">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4 gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-gray-800 border-l-4 border-emerald-500 pl-3 mb-2">MSDS Chemical</h3>
                    <p class="text-gray-600 text-sm ml-4">Lembar Data Keselamatan Bahan yang berisi informasi penting tentang sifat kimia, bahaya, dan penanganan yang aman.</p>
                </div>
                @auth
                    @if(Auth::user()->is_admin)
                        <button onclick="openModal('msds')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm whitespace-nowrap">
                            <i class="fas fa-plus mr-1"></i> Tambah Dokumen
                        </button>
                    @endif
                @endauth
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($msds as $doc)
                    @include('components.document-card', ['doc' => $doc])
                @empty
                    <div class="col-span-1 md:col-span-2 lg:col-span-3">
                        <div class="border border-dashed rounded-lg p-8 text-center">
                            <i class="fas fa-flask text-3xl text-gray-400 mb-2"></i>
                            <div class="font-semibold text-gray-700">Belum ada dokumen MSDS Chemical</div>
                            <div class="text-sm text-gray-500">Unggah MSDS untuk ditampilkan di sini.</div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Modals -->
    @auth
        @if(Auth::user()->is_admin)
            <!-- Add Document Modal -->
            <div id="addDocumentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('addDocumentModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 id="modalTitle" class="text-xl font-bold mb-4 text-gray-800">Tambah Dokumen</h3>
                    
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" id="documentTypeInput">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Judul Dokumen</label>
                                <input type="text" name="title" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi</label>
                                <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">File (PDF Wajib)</label>
                                <input type="file" name="file" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept=".pdf">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('addDocumentModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Document Modal -->
            <div id="editDocumentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editDocumentModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Edit Dokumen</h3>
                    
                    <form id="editDocumentForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="type" id="editDocumentType">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Judul Dokumen</label>
                                <input type="text" id="editDocumentTitle" name="title" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi</label>
                                <textarea id="editDocumentDescription" name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Ganti File (Opsional, PDF Wajib)</label>
                                <input type="file" name="file" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept=".pdf">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editDocumentModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function openModal(type) {
                    document.getElementById('documentTypeInput').value = type;
                    const titles = {
                        'coa': 'Certificate of Analysis',
                        'incoming': 'Incoming Material',
                        'msds': 'MSDS Chemical'
                    };
                    document.getElementById('modalTitle').innerText = 'Tambah ' + titles[type];
                    document.getElementById('addDocumentModal').classList.remove('hidden');
                }

                function openEditDocumentModal(button) {
                    const id = button.getAttribute('data-id');
                    const title = button.getAttribute('data-title');
                    const type = button.getAttribute('data-type');
                    const description = button.getAttribute('data-description');
                    const url = button.getAttribute('data-url');

                    const form = document.getElementById('editDocumentForm');
                    form.action = url;
                    
                    document.getElementById('editDocumentTitle').value = title;
                    document.getElementById('editDocumentType').value = type;
                    document.getElementById('editDocumentDescription').value = description || '';
                    
                    document.getElementById('editDocumentModal').classList.remove('hidden');
                }
            </script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (window.location.hash === '#add') {
                        var type = 'coa';
                        var typeInput = document.getElementById('documentTypeInput');
                        if (typeInput) typeInput.value = type;
                        var modal = document.getElementById('addDocumentModal');
                        if (modal) modal.classList.remove('hidden');
                    }
                });
            </script>
        @endif
    @endauth

@endsection
