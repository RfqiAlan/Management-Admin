<x-admin-layout title="Edit Pengguna" header="Edit Pengguna">
    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-right">
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Daftar Pengguna</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl" data-aos="fade-up">
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br {{ $user->role === 'admin' ? 'from-indigo-400 to-purple-500' : 'from-emerald-400 to-teal-500' }} flex items-center justify-center text-white text-2xl font-bold shadow-lg">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-semibold mt-1 {{ $user->role === 'admin' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $user->role === 'admin' ? 'Administrator' : 'Mahasiswa' }}
                    </span>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-1 text-indigo-500"></i>Nama Lengkap
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                               class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                               required>
                        @error('name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-envelope mr-1 text-indigo-500"></i>Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                               class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                               required>
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1 text-indigo-500"></i>Nomor WhatsApp
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                               placeholder="08xx..."
                               class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                        @error('phone')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user-tag mr-1 text-indigo-500"></i>Role / Peran
                        </label>
                        <select name="role" id="role"
                                class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                            <option value="student" {{ old('role', $user->role) === 'student' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                        </select>
                        @error('role')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Password Section -->
                <div class="pt-6 border-t border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <i class="fas fa-lock text-indigo-500"></i>
                        Ubah Password (Opsional)
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <input type="password" name="password" id="password"
                                   placeholder="Kosongkan jika tidak ubah"
                                   class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                            @error('password')
                                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password
                            </label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                   class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                        </div>
                    </div>
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.users.index') }}" 
                       class="px-6 py-4 bg-gray-100 text-gray-600 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
