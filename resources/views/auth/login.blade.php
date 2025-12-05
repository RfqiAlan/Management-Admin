<x-guest-layout>
    <!-- Header -->
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Selamat Datang! 👋</h2>
        <p class="text-gray-500">Masuk ke akun kamu untuk melanjutkan</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-envelope mr-1 text-indigo-500"></i>Email Kampus
            </label>
            <input type="email" name="email" id="email" value="{{ old('email') }}"
                   placeholder="nama@kampus.ac.id"
                   class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                   required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="fas fa-lock mr-1 text-indigo-500"></i>Password
            </label>
            <div class="relative" x-data="{ showPassword: false }">
                <input :type="showPassword ? 'text' : 'password'" name="password" id="password"
                       placeholder="••••••••"
                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all pr-12"
                       required autocomplete="current-password">
                <button type="button" @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-gray-600">
                    <i class="fas" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember & Forgot -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember"
                       class="w-4 h-4 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-600">Ingat Saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    Lupa Password?
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
            <i class="fas fa-sign-in-alt"></i>
            <span>Masuk</span>
        </button>

        <!-- Register Link -->
        <div class="text-center pt-4 border-t border-gray-100">
            <span class="text-gray-600">Belum punya akun?</span>
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:text-indigo-800 ml-1">
                Daftar disini
            </a>
        </div>
    </form>
</x-guest-layout>
