@php
    $isAdmin = auth()->user()->isAdmin();
    $layoutComponent = $isAdmin ? 'admin-layout' : 'student-layout';
@endphp

<x-dynamic-component :component="$layoutComponent" title="Profil Saya" header="Profil Saya">
    <div class="max-w-3xl {{ $isAdmin ? '' : 'mx-auto' }}">
        <!-- Profile Card -->
        <div class="glass-card rounded-2xl overflow-hidden" data-aos="fade-up">
            <!-- Header Gradient -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 px-8 py-6">
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur-sm flex items-center justify-center ring-4 ring-white/30 shadow-2xl">
                        <span class="text-3xl font-bold text-white">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="min-w-0">
                        <p class="text-indigo-100 text-sm mb-1">Akun terhubung sebagai</p>
                        <h2 class="text-2xl font-bold text-white truncate">{{ $user->name }}</h2>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-white/80 text-sm">{{ $user->email }}</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white">
                                {{ $isAdmin ? 'Administrator' : 'Mahasiswa' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Body -->
            <div class="p-8">
                @if(session('success'))
                    <div class="mb-6 flex items-center gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700">
                        <i class="fas fa-check-circle text-lg"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700">
                        <div class="flex items-center gap-2 font-semibold mb-2">
                            <i class="fas fa-exclamation-triangle"></i>
                            <span>Periksa kembali isian kamu:</span>
                        </div>
                        <ul class="list-disc pl-6 text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')

                    <!-- Personal Info Section -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center">
                                <i class="fas fa-user text-indigo-600"></i>
                            </div>
                            <h3 class="font-semibold text-gray-800">Informasi Pribadi</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" required
                                       value="{{ old('name', $user->name) }}"
                                       placeholder="Masukkan nama lengkap"
                                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all @error('name') border-rose-400 @enderror">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email <span class="text-rose-500">*</span>
                                </label>
                                <input type="email" name="email" id="email" required
                                       value="{{ old('email', $user->email) }}"
                                       placeholder="nama@kampus.ac.id"
                                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all @error('email') border-rose-400 @enderror">
                            </div>

                            <!-- Phone -->
                            <div class="md:col-span-2">
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fab fa-whatsapp mr-1 text-green-500"></i>
                                    Nomor WhatsApp
                                </label>
                                <input type="text" name="phone" id="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="08xxxxxxxxxx"
                                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all @error('phone') border-rose-400 @enderror">
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Untuk menerima notifikasi status keluhan
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Security Section -->
                    <div class="pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-8 h-8 rounded-lg bg-amber-100 flex items-center justify-center">
                                <i class="fas fa-lock text-amber-600"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">Keamanan Akun</h3>
                                <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengganti password</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- New Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password Baru
                                </label>
                                <input type="password" name="password" id="password"
                                       placeholder="Minimal 8 karakter"
                                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all @error('password') border-rose-400 @enderror">
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation"
                                       placeholder="Ulangi password baru"
                                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                        <button type="submit" 
                                class="flex-1 px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02] flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                        <button type="button" onclick="window.history.back()"
                                class="px-6 py-4 bg-gray-100 text-gray-600 rounded-xl font-semibold hover:bg-gray-200 transition-all flex items-center justify-center gap-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-dynamic-component>
