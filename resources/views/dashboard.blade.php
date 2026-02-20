<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <h3 class="text-2xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h3>
                <p class="text-gray-600">Berikut adalah ringkasan data website Wilmar Nabati Indonesia.</p>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-10">
                <!-- Team Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tim & Karyawan</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['team'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Equipment Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                            <i class="fas fa-flask text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Alat Labor</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['equipment'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Products Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-orange-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-orange-100 text-orange-500 mr-4">
                            <i class="fas fa-box-open text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Produk</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['products'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Flow Stats -->
                @if(Auth::user()->is_admin)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-emerald-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-emerald-100 text-emerald-500 mr-4">
                            <i class="fas fa-diagram-project text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Flow Proses</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['flows'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Documents Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-red-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100 text-red-500 mr-4">
                            <i class="fas fa-file-alt text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Dokumen</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['documents'] }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Quick Links -->
            <h3 class="text-xl font-bold text-gray-800 mb-4">Menu Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <a href="{{ route('home') }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition flex items-center justify-between group">
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-emerald-600 transition">Kelola Beranda</h4>
                        <p class="text-sm text-gray-500">Edit Struktur Organisasi & Tim</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600 transition"></i>
                </a>

                <a href="{{ route('laboratorium') }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition flex items-center justify-between group">
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-emerald-600 transition">Kelola Laboratorium</h4>
                        <p class="text-sm text-gray-500">Edit Alat & Produk</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600 transition"></i>
                </a>

                @if(Auth::user()->is_admin)
                <a href="{{ route('flow') }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition flex items-center justify-between group">
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-emerald-600 transition">Kelola Flow Proses</h4>
                        <p class="text-sm text-gray-500">Tambah dan atur alur proses</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600 transition"></i>
                </a>
                @endif

                @if(Auth::user()->is_admin)
                <a href="{{ route('documents.index') }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition flex items-center justify-between group">
                    <div>
                        <h4 class="font-bold text-gray-800 group-hover:text-emerald-600 transition">Kelola Dokumen</h4>
                        <p class="text-sm text-gray-500">Upload COA, MSDS, dll</p>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-emerald-600 transition"></i>
                </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
