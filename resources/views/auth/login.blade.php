<x-guest-layout>
    <!-- Logo & Header -->
    <div class="text-center mb-8">
        <div class="flex justify-center mb-4">
            <!-- Batasi lebar logo agar tidak meledak -->
            <img src="{{ asset('img/logo.png') }}" alt="Wilmar Logo" class="h-20 w-auto object-contain">
        </div>
        <h2 class="text-2xl font-bold text-gray-800">Wilmar Nabati</h2>
        <p class="text-emerald-600 font-medium text-sm tracking-wider uppercase">Portal Administrator</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-700 mb-1">Email Address</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-envelope text-gray-400"></i>
                </div>
                <input id="email" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm" 
                       type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan email anda" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-medium text-sm text-gray-700 mb-1">Password</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-lock text-gray-400"></i>
                </div>
                <input id="password" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500 sm:text-sm" 
                       type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password anda" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Actions -->
        <div class="flex flex-col gap-3 mt-6">
            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150">
                Masuk Dashboard
            </button>
            
            <a href="{{ route('home') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150">
                <i class="fas fa-arrow-left mr-2 mt-0.5"></i> Kembali ke Beranda
            </a>
        </div>
    </form>
</x-guest-layout>
