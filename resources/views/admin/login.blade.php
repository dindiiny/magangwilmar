@extends('layouts.app')

@section('title', 'Admin Login')

@section('content')
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-md p-8">
        <h1 class="text-2xl font-bold text-emerald-800 mb-4 text-center">Login Admin</h1>
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500" required>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded hover:bg-emerald-700">Login</button>
            </div>
        </form>
    </div>
@endsection

