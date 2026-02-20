@extends('layouts.public')

@section('title', 'Beranda - Wilmar Nabati Indonesia')

@section('content')
    <!-- Intro Section -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-10 border-l-4 border-emerald-600 relative group">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">{{ $pageContents['welcome']->title ?? 'Selamat Datang di Wina Dumai' }}</h2>
        <p class="text-gray-600 text-lg leading-relaxed">
            {{ $pageContents['welcome']->content ?? 'Wilmar Nabati Indonesia...' }}
        </p>
        @auth
            @if(Auth::user()->is_admin)
                <button 
                    data-section="welcome"
                    data-title="{{ $pageContents['welcome']->title ?? '' }}"
                    data-content="{{ $pageContents['welcome']->content ?? '' }}"
                    onclick="openEditContentModal(this)"
                    class="absolute top-4 right-4 text-emerald-600 hover:text-emerald-800 hidden group-hover:block">
                    <i class="fas fa-edit"></i> Edit
                </button>
            @endif
        @endauth
    </div>

    <!-- Visi Misi Section -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 border-b-2 border-emerald-500 pb-2">Visi & Misi</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="relative group">
                <h3 class="text-xl font-bold text-emerald-700 mb-2">{{ $pageContents['vision']->title ?? 'Visi' }}</h3>
                <p class="text-gray-600 text-lg leading-relaxed">
                    {{ $pageContents['vision']->content ?? '...' }}
                </p>
                @auth
                    @if(Auth::user()->is_admin)
                        <button 
                            data-section="vision"
                            data-title="{{ $pageContents['vision']->title ?? '' }}"
                            data-content="{{ $pageContents['vision']->content ?? '' }}"
                            onclick="openEditContentModal(this)"
                            class="absolute top-0 right-0 text-emerald-600 hover:text-emerald-800 hidden group-hover:block">
                            <i class="fas fa-edit"></i>
                        </button>
                    @endif
                @endauth
            </div>
            <div class="relative group">
                <h3 class="text-xl font-bold text-emerald-700 mb-2">{{ $pageContents['mission']->title ?? 'Misi' }}</h3>
                <div class="text-gray-600 text-lg leading-relaxed list-disc-container">
                    {!! $pageContents['mission']->content ?? '...' !!}
                </div>
                @auth
                    @if(Auth::user()->is_admin)
                        <button 
                            data-section="mission"
                            data-title="{{ $pageContents['mission']->title ?? '' }}"
                            data-content="{{ $pageContents['mission']->content ?? '' }}"
                            onclick="openEditContentModal(this)"
                            class="absolute top-0 right-0 text-emerald-600 hover:text-emerald-800 hidden group-hover:block">
                            <i class="fas fa-edit"></i>
                        </button>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Struktur Organisasi Section -->
    <div class="bg-white rounded-lg shadow-lg p-8 mb-10 text-center">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b-2 border-emerald-500 pb-2 inline-block">
            {{ $structure->title ?? 'Struktur Organisasi' }}
        </h2>
        
        @if(isset($structure) && $structure->description)
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">{{ $structure->description }}</p>
        @endif

        <div class="flex justify-center relative group">
            <div class="max-w-xl relative">
                @if(isset($structure) && $structure->image)
                    <img src="{{ Storage::url($structure->image) }}" alt="Struktur Organisasi" class="rounded-lg shadow-md w-full">
                @else
                    <img src="{{ asset('img/struktur.png') }}" alt="Struktur Organisasi" class="rounded-lg shadow-md w-full">
                @endif
                
                @auth
                    @if(Auth::user()->is_admin)
                        <button onclick="document.getElementById('editStructureModal').classList.remove('hidden')" class="absolute top-2 right-2 bg-emerald-600 hover:bg-emerald-700 text-white p-2 rounded shadow">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="mb-8 flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800 border-b-2 border-emerald-500 pb-2">Tim & Karyawan</h2>
        @auth
            @if(Auth::user()->is_admin)
                <button onclick="document.getElementById('addTeamModal').classList.remove('hidden')" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded shadow text-sm">
                    <i class="fas fa-plus mr-1"></i> Tambah Anggota
                </button>
            @endif
        @endauth
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($teamMembers as $member)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                <div class="h-64 bg-gray-200 relative group">
                    @if($member->image)
                        <img src="{{ Storage::disk('public')->url($member->image) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                            <i class="fas fa-user text-6xl"></i>
                        </div>
                    @endif
                    
                    @auth
                        @if(Auth::user()->is_admin)
                            <div class="absolute top-2 right-2 hidden group-hover:flex space-x-2">
                                <button 
                                    data-id="{{ $member->id }}"
                                    data-name="{{ $member->name }}"
                                    data-role="{{ $member->role }}"
                                    data-description="{{ $member->description }}"
                                    data-url="{{ route('team.update', $member->id) }}"
                                    onclick="openEditTeamModal(this)" 
                                    class="bg-yellow-500 text-white p-2 rounded-full hover:bg-yellow-600 shadow">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Hapus anggota ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 shadow">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-lg text-gray-800">{{ $member->name }}</h3>
                    <p class="text-emerald-600 font-medium text-sm">{{ $member->role }}</p>
                    @if($member->description)
                        <p class="text-gray-500 text-xs mt-2">{{ Str::limit($member->description, 50) }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-1 sm:col-span-2 lg:col-span-4">
                <div class="border border-dashed rounded-lg p-8 text-center">
                    <i class="fas fa-users text-3xl text-gray-400 mb-2"></i>
                    <div class="font-semibold text-gray-700">Belum ada anggota tim atau karyawan</div>
                    <div class="text-sm text-gray-500">Tambahkan anggota untuk ditampilkan di sini.</div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Add Team Modal -->
    @auth
        @if(Auth::user()->is_admin)
            <!-- Add Team Modal -->
            <div id="addTeamModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('addTeamModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Tambah Anggota Tim</h3>
                    
                    <form action="{{ route('team.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Nama Lengkap</label>
                                <input type="text" name="name" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Peran / Jabatan</label>
                                <select name="role" class="w-full border rounded px-3 py-2 focus:outline-emerald-500">
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="Anak Magang">Anak Magang</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi (Opsional)</label>
                                <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="2"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Foto</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500">
                                <p class="text-xs text-gray-500 mt-1">Format gambar: JPG, PNG. Maksimal ukuran file 5 MB.</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('addTeamModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Team Modal -->
            <div id="editTeamModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editTeamModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Edit Anggota Tim</h3>
                    
                    <form id="editTeamForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Nama Lengkap</label>
                                <input type="text" id="edit_team_name" name="name" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Peran / Jabatan</label>
                                <select id="edit_team_role" name="role" class="w-full border rounded px-3 py-2 focus:outline-emerald-500">
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="Anak Magang">Anak Magang</option>
                                    <option value="Staff">Staff</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi (Opsional)</label>
                                <textarea id="edit_team_description" name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="2"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Ubah Foto (Opsional)</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto. Maksimal ukuran file 5 MB.</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editTeamModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Structure Modal -->
            <div id="editStructureModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-md mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editStructureModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Edit Struktur Organisasi</h3>
                    
                    <form action="{{ route('structure.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Judul</label>
                                <input type="text" name="title" value="{{ $structure->title ?? 'Struktur Organisasi' }}" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Deskripsi (Opsional)</label>
                                <textarea name="description" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" rows="2">{{ $structure->description ?? '' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Upload Gambar Baru</label>
                                <input type="file" name="image" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" @if(!isset($structure)) required @endif accept="image/*">
                                <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Maksimal ukuran file 5 MB.</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editStructureModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Page Content Modal -->
            <div id="editContentModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg w-full max-w-2xl mx-4 p-6 shadow-2xl relative">
                    <button onclick="document.getElementById('editContentModal').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                    
                    <h3 class="text-xl font-bold mb-4 text-gray-800" id="editContentModalTitle">Edit Konten</h3>
                    
                    <form action="{{ route('page.content.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="section" id="edit_content_section">
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Judul</label>
                                <input type="text" name="title" id="edit_content_title" class="w-full border rounded px-3 py-2 focus:outline-emerald-500" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-1">Konten</label>
                                <textarea name="content" id="edit_content_body" class="w-full border rounded px-3 py-2 focus:outline-emerald-500 font-mono text-sm" rows="10" required></textarea>
                                <p class="text-xs text-gray-500 mt-1">Anda dapat menggunakan tag HTML sederhana (seperti &lt;p&gt;, &lt;br&gt;, &lt;ul&gt;, &lt;li&gt;).</p>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="document.getElementById('editContentModal').classList.add('hidden')" class="mr-3 px-4 py-2 text-gray-600 hover:text-gray-800">Batal</button>
                            <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            <script>
                function openEditContentModal(button) {
                    const section = button.getAttribute('data-section');
                    const title = button.getAttribute('data-title');
                    const content = button.getAttribute('data-content');

                    document.getElementById('edit_content_section').value = section;
                    document.getElementById('edit_content_title').value = title;
                    document.getElementById('edit_content_body').value = content;
                    
                    // Update modal title based on section
                    let modalTitle = 'Edit Konten';
                    if(section === 'welcome') modalTitle = 'Edit Sambutan';
                    else if(section === 'vision') modalTitle = 'Edit Visi';
                    else if(section === 'mission') modalTitle = 'Edit Misi';
                    document.getElementById('editContentModalTitle').innerText = modalTitle;

                    document.getElementById('editContentModal').classList.remove('hidden');
                }

                function openEditTeamModal(button) {
                    const id = button.getAttribute('data-id');
                    const name = button.getAttribute('data-name');
                    const role = button.getAttribute('data-role');
                    const description = button.getAttribute('data-description');
                    const url = button.getAttribute('data-url');

                    const form = document.getElementById('editTeamForm');
                    form.action = url;
                    
                    document.getElementById('edit_team_name').value = name;
                    document.getElementById('edit_team_role').value = role;
                    document.getElementById('edit_team_description').value = description || '';
                    
                    document.getElementById('editTeamModal').classList.remove('hidden');
                }
            </script>
        @endif
    @endauth

@endsection
