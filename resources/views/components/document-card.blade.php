<div class="bg-white rounded-lg shadow-md p-6 relative group hover:shadow-lg transition">
    <div class="flex items-center mb-4">
        @if(Str::endsWith($doc->file_path, ['.jpg', '.jpeg', '.png']))
            <i class="fas fa-image text-emerald-500 text-3xl mr-3"></i>
        @else
            <i class="fas fa-file-pdf text-red-500 text-3xl mr-3"></i>
        @endif
        <div class="flex-1 min-w-0">
            <h4 class="font-bold text-gray-800 truncate" title="{{ $doc->title }}">{{ $doc->title }}</h4>
            <p class="text-xs text-gray-500">{{ $doc->created_at->format('d M Y') }}</p>
        </div>
    </div>
    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $doc->description }}</p>
    <div class="flex justify-between items-center">
        @if($doc->file_path)
            <a href="{{ Storage::url($doc->file_path) }}" download target="_blank" class="text-emerald-600 hover:text-emerald-800 text-sm font-bold flex items-center transition duration-200">
                Download PDF <i class="fas fa-file-download ml-2 text-lg"></i>
            </a>
        @else
            <span class="text-gray-400 text-sm italic">File tidak tersedia</span>
        @endif
    </div>

    @auth
        @if(Auth::user()->is_admin)
            <div class="absolute top-2 right-2 hidden group-hover:flex space-x-1">
                <button 
                    data-id="{{ $doc->id }}"
                    data-title="{{ $doc->title }}"
                    data-type="{{ $doc->type }}"
                    data-description="{{ $doc->description }}"
                    data-url="{{ route('documents.update', $doc->id) }}"
                    onclick="openEditDocumentModal(this)" 
                    class="bg-yellow-500 text-white p-1.5 rounded-full shadow hover:bg-yellow-600 text-xs">
                    <i class="fas fa-edit"></i>
                </button>
                <form action="{{ route('documents.destroy', $doc->id) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?');">
                    @csrf @method('DELETE')
                    <button class="bg-red-500 text-white p-1.5 rounded-full shadow hover:bg-red-600 text-xs"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        @endif
    @endauth
</div>