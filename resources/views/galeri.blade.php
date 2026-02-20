@extends('layouts.public')

@section('title', 'Galeri - Wilmar Nabati Indonesia')

@section('content')
    <div class="flex flex-col md:flex-row justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-emerald-800">Galeri Alat & Kegiatan</h1>
            <p class="text-gray-600">Dokumentasi alat laboratorium dan penggunaannya.</p>
        </div>
        <button onclick="document.getElementById('inputForm').classList.toggle('hidden')" class="mt-4 md:mt-0 bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow transition flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah Data
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Sukses!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Input Form -->
    <div id="inputForm" class="hidden bg-white p-6 rounded-lg shadow-md mb-8 border border-emerald-100">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Input Data Baru</h3>
        <form action="{{ route('galeri.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div class="col-span-1">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Alat / Kegiatan</label>
                <input type="text" name="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-emerald-500" placeholder="Contoh: Mikroskop" required>
            </div>
            <div class="col-span-1">
                <label class="block text-gray-700 text-sm font-bold mb-2">Upload Foto</label>
                <input type="file" name="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <p class="text-xs text-gray-500 mt-1">Format gambar: JPG, PNG. Maksimal ukuran file 5 MB.</p>
            </div>
            <div class="col-span-2">
                <label class="block text-gray-700 text-sm font-bold mb-2">Kegunaan / Deskripsi</label>
                <textarea name="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline focus:border-emerald-500" rows="3" placeholder="Jelaskan kegunaan alat ini..."></textarea>
            </div>
            <div class="col-span-2 flex justify-end">
                <button type="submit" class="bg-emerald-600 text-white font-bold py-2 px-6 rounded hover:bg-emerald-700 transition">Simpan</button>
            </div>
        </form>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleryItems as $item)
        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
            <div class="relative h-48 bg-gray-200 group overflow-hidden">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                
                <!-- Overlay on hover -->
                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition duration-300"></div>
            </div>
            <div class="p-5">
                <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $item->title }}</h3>
                <p class="text-gray-600 text-sm leading-relaxed">
                    {{ $item->description }}
                </p>
            </div>
            <div class="px-5 pb-5 pt-0">
                <span class="inline-block bg-emerald-100 rounded-full px-3 py-1 text-xs font-semibold text-emerald-700 mr-2 mb-2">#Laboratorium</span>
                <span class="inline-block bg-emerald-100 rounded-full px-3 py-1 text-xs font-semibold text-emerald-700 mr-2 mb-2">#Wilmar</span>
            </div>
        </div>
        @empty
        <div class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-10 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
            <i class="fas fa-images text-4xl text-gray-300 mb-4"></i>
            <p class="text-gray-500">Belum ada data galeri.</p>
            <p class="text-gray-400 text-sm">Silakan tambahkan data baru menggunakan tombol di atas.</p>
        </div>
        @endforelse
    </div>
@endsection
