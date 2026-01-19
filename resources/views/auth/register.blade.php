<x-guest-layout>
    {{-- CSS untuk memaksa logo Laravel bawaan hilang --}}
    <style>
        .min-h-screen > div:first-child > a { display: none !important; }
    </style>

    <x-slot name="logo"></x-slot>

    {{-- Header --}}
    <div class="mb-6 text-center pt-4">
        <h2 class="text-2xl font-bold" style="color: #1e3a8a;">Daftar Akun</h2>
        <p class="text-sm text-gray-600">Bergabunglah untuk mulai meminjam buku</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="name" value="Nama Lengkap" style="color: #1e3a8a; font-weight: 600;" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" 
                type="text" name="name" :value="old('name')" required autofocus autocomplete="name" 
                placeholder="Masukkan nama lengkap Anda" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="email" value="Email" style="color: #1e3a8a; font-weight: 600;" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm" 
                type="email" name="email" :value="old('email')" required autocomplete="username" 
                placeholder="nama@email.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" value="Password" style="color: #1e3a8a; font-weight: 600;" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Konfirmasi Password" style="color: #1e3a8a; font-weight: 600;" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-lg shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" 
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex flex-col items-center justify-end mt-6 gap-3">
            <x-primary-button class="w-full justify-center py-3 text-sm font-bold uppercase tracking-widest shadow-md transition duration-150" 
                style="background-color: #1e3a8a; border-radius: 10px;">
                Daftar Sekarang
            </x-primary-button>

            <p class="text-sm text-gray-600 mt-2">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold hover:underline" style="color: #1e3a8a;">Masuk di sini</a>
            </p>
        </div>
    </form>
</x-guest-layout>