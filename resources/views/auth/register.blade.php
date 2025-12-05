<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Buat Akun Baru 🎓</h2>
        <p class="text-gray-500">Daftar untuk mulai melaporkan keluhan</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-user mr-1 text-indigo-500"></i>Nama Lengkap
            </label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   placeholder="Masukkan nama lengkap"
                   class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                   required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-1 text-indigo-500"></i>Email Kampus
            </label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   placeholder="nama@kampus.ac.id"
                   class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                   required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fab fa-whatsapp mr-1 text-green-500"></i>Nomor WhatsApp
            </label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                   placeholder="08xxxxxxxxxx"
                   class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                   required>
            <p class="text-xs text-gray-500 mt-1">
                <i class="fas fa-info-circle mr-1"></i>
                Untuk notifikasi status keluhan
            </p>
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1 text-indigo-500"></i>Password
                </label>
                <input type="password" name="password" id="password"
                       placeholder="Min. 8 karakter"
                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                       required autocomplete="new-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-lock mr-1 text-indigo-500"></i>Konfirmasi
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       placeholder="Ulangi password"
                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                       required autocomplete="new-password">
            </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
            <i class="fas fa-user-plus"></i>
            <span>Daftar Sekarang</span>
        </button>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-gray-100">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 ml-1">
                Masuk disini
            </a>
        </div>
    </form>
</x-guest-layout>
