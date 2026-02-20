@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-emerald-800">Admin Dashboard</h1>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="bg-red-600 text-white px-4 py-2 rounded">Logout</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Tambah Flow Proses</h2>
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('flow.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Step</label>
                <input type="number" name="step" min="1" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Judul</label>
                <input type="text" name="title" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">Gambar (opsional)</label>
                <input type="file" name="image" class="w-full border rounded px-3 py-2">
                <p class="text-xs text-gray-500 mt-1">Format gambar: JPG, PNG. Maksimal ukuran file 5 MB.</p>
            </div>
            <div class="md:col-span-2 flex justify-end">
                <button class="bg-emerald-600 text-white px-6 py-2 rounded hover:bg-emerald-700">Simpan</button>
            </div>
        </form>
    </div>
@endsection
