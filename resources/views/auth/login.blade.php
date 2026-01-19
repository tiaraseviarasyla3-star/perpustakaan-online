<x-guest-layout>
    {{-- CSS untuk memaksa logo Laravel bawaan hilang --}}
    <style>
        /* Mencari elemen pembungkus logo di Breeze dan menyembunyikannya */
        .min-h-screen > div:first-child > a { display: none !important; }
    </style>

    <x-slot name="logo"></x-slot>

    {{-- Header --}}
    <div class="mb-6 text-center pt-4"> {{-- Tambah sedikit padding top --}}
        <h2 class="text-2xl font-bold" style="color: #1e3a8a;">Selamat Datang</h2>
        <p class="text-sm text-gray-600">Silakan masuk ke akun Anda</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Email" style="color: #1e3a8a; font-weight: 600;" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" 
                type="email" name="email" :value="old('email')" required autofocus autocomplete="username" 
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" style="color: #1e3a8a; font-weight: 600;" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-900 shadow-sm focus:ring-blue-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-blue-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif
        </div>

        <div class="flex flex-col items-center justify-end mt-6 gap-3">
            <x-primary-button class="w-full justify-center py-3 text-sm font-bold uppercase tracking-widest shadow-md transition duration-150" 
                style="background-color: #1e3a8a; border-radius: 10px;">
                Masuk Sekarang
            </x-primary-button>
            
            <p class="text-sm text-gray-600 mt-2">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold hover:underline" style="color: #1e3a8a;">Daftar di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>