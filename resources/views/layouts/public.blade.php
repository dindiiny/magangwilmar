<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Wilmar Nabati Indonesia')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            50:  '#e8f5f6',
                            100: '#d1eaec',
                            200: '#a8d7da',
                            300: '#7fc4c8',
                            400: '#49aeb3',
                            500: '#1a959c',
                            600: '#138086',
                            700: '#0f6f76',
                            800: '#0a5f64',
                            900: '#064e52',
                            950:'#033d40',
                        }
                    }
                }
            }
        }
    </script>
    <script src="//unpkg.com/alpinejs" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar-active { 
            background-color: rgba(255, 255, 255, 0.1); 
            border-left: 4px solid #49aeb3;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans text-gray-800">

    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar -->
        <aside class="bg-emerald-900 text-white w-full md:w-64 flex-shrink-0 flex flex-col shadow-xl">
            <!-- Logo Area -->
            <div class="p-6 flex flex-col items-center justify-center border-b border-emerald-800 bg-emerald-950">
                 <div class="bg-white p-2 rounded-lg mb-3 w-24 h-24 flex items-center justify-center overflow-hidden">
                    <!-- Logo Instruction: Place logo.png in public/img/ folder -->
                    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="max-w-full max-h-full object-contain" onerror="this.onerror=null; this.src='https://via.placeholder.com/150?text=LOGO';">
                 </div>
                 <h1 class="text-xl font-bold tracking-wider">WILMAR</h1>
                 <p class="text-xs text-emerald-400 uppercase tracking-widest">Nabati Indonesia</p>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-grow py-6 space-y-1">
                <a href="{{ route('home') }}" class="flex items-center py-3 px-6 hover:bg-emerald-800 transition duration-200 {{ request()->routeIs('home') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-home w-6 text-center mr-3"></i>
                    <span class="font-medium">Beranda</span>
                </a>
                <a href="{{ route('laboratorium') }}" class="flex items-center py-3 px-6 hover:bg-emerald-800 transition duration-200 {{ request()->routeIs('laboratorium') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-flask w-6 text-center mr-3"></i>
                    <span class="font-medium">Laboratorium</span>
                </a>
                <a href="{{ route('sevens') }}" class="flex items-center py-3 px-6 hover:bg-emerald-800 transition duration-200 {{ request()->routeIs('sevens') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-list-check w-6 text-center mr-3"></i>
                    <span class="font-medium">Kegiatan 7S</span>
                </a>
                <a href="{{ route('housekeeping') }}" class="flex items-center py-3 px-6 hover:bg-emerald-800 transition duration-200 {{ request()->routeIs('housekeeping') ? 'sidebar-active' : '' }}">
                    <i class="fas fa-broom w-6 text-center mr-3"></i>
                    <span class="font-medium">House Keeping</span>
                </a>
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('documents.index') }}" class="flex items-center py-3 px-6 hover:bg-emerald-800 transition duration-200 {{ request()->routeIs('documents.index') ? 'sidebar-active' : '' }}">
                            <i class="fas fa-file-alt w-6 text-center mr-3"></i>
                            <span class="font-medium">Laporan & Dokumen</span>
                        </a>
                    @endif
                @endauth
            </nav>
            
            
            
            <!-- Auth Links -->
            <div class="p-4 border-t border-emerald-800 bg-emerald-950">
                @auth
                    <div class="bg-emerald-800 rounded-lg p-3 shadow-inner">
                        <div class="flex items-center mb-2">
                            <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center mr-2">
                                <i class="fas fa-user text-xs"></i>
                            </div>
                            <div>
                                <p class="text-xs text-emerald-300">Login sebagai</p>
                                <p class="text-sm font-bold text-white leading-tight">{{ Auth::user()->name }}</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-3 rounded transition duration-200 flex items-center justify-center">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="block bg-emerald-700 hover:bg-emerald-600 text-white text-center py-2 px-4 rounded transition duration-200 shadow font-medium">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login Admin
                    </a>
                @endauth
            </div>

            <!-- Footer Sidebar -->
            <div class="p-6 text-xs text-emerald-400 text-center border-t border-emerald-800">
                <p>&copy; {{ date('Y') }} Laboratorium PT Wilmar Nabati Indonesia Unit Dumai</p>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="flex-grow w-full bg-gray-50 flex flex-col">
            <!-- Mobile Header (Visible only on mobile) -->
            <div class="md:hidden bg-emerald-900 text-white p-4 flex justify-between items-center shadow">
                <span class="font-bold">Wilmar Nabati</span>
                <button onclick="alert('Menu sidebar ada di atas (tampilan mobile sederhana)')" class="text-white focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Content -->
            <div class="p-6 md:p-10 overflow-y-auto h-full">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p class="font-bold">Sukses</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>
