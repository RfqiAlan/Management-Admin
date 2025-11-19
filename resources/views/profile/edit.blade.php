<x-app-layout title="Profil Saya">
    <div class="max-w-4xl mx-auto px-4 py-6">

        {{-- PAGE HEADER --}}
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h1 class="text-lg font-semibold text-slate-900">
                    Profil Saya
                </h1>
                <p class="text-sm text-slate-500">
                    Perbarui informasi akun kamu: nama, email, nomor HP, dan password.
                </p>
            </div>

            <span
                class="inline-flex items-center rounded-full border border-indigo-100 bg-indigo-50 px-3 py-1 text-xs font-medium text-indigo-700">
                <span class="mr-1 h-1.5 w-1.5 rounded-full bg-indigo-500"></span>
                {{ auth()->user()->isAdmin() ? 'Administrator' : 'Mahasiswa' }}
            </span>
        </div>

        {{-- CARD --}}
        <div class="overflow-hidden rounded-2xl border border-slate-100 bg-white shadow-sm">

            {{-- CARD HEADER GRADIENT --}}
            <div class="bg-gradient-to-r from-indigo-600 via-indigo-500 to-sky-500 px-6 py-4">
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-full bg-white/15 ring-2 ring-white/30 backdrop-blur-sm">
                        <span class="text-xl font-semibold text-white">
                            {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium text-indigo-100">
                            Akun terhubung sebagai
                        </p>
                        <p class="truncate text-base font-semibold text-white">
                            {{ $user->name }}
                        </p>
                        <p class="truncate text-xs text-indigo-100/80">
                            {{ $user->email }}
                            @if($user->phone)
                                • {{ $user->phone }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            {{-- CARD BODY --}}
            <div class="px-6 py-5 space-y-5">

                {{-- ALERTS --}}
                @if(session('success'))
                    <div
                        class="flex items-start gap-2 rounded-xl border border-emerald-100 bg-emerald-50 px-3 py-2 text-xs text-emerald-800">
                        <svg class="mt-0.5 h-4 w-4" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 3L2 21H22L12 3Z" stroke="currentColor" stroke-width="1.5"
                                  stroke-linejoin="round"/>
                            <path d="M12 10V14" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round"/>
                            <path d="M12 17V17.5" stroke="currentColor" stroke-width="1.5"
                                  stroke-linecap="round"/>
                        </svg>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div
                        class="space-y-1 rounded-xl border border-rose-100 bg-rose-50 px-3 py-2 text-xs text-rose-700">
                        <div class="flex items-center gap-1.5 font-medium">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3L2 21H22L12 3Z" stroke="currentColor" stroke-width="1.5"
                                      stroke-linejoin="round"/>
                                <path d="M12 9V13" stroke="currentColor" stroke-width="1.5"
                                      stroke-linecap="round"/>
                                <path d="M12 16V16.5" stroke="currentColor" stroke-width="1.5"
                                      stroke-linecap="round"/>
                            </svg>
                            <span>Periksa kembali isian kamu:</span>
                        </div>
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- SECTION: INFO PRIBADI --}}
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Informasi pribadi
                            </h2>
                            <span class="text-[11px] text-slate-400">
                                Digunakan untuk identitas dalam sistem keluhan.
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            {{-- Nama --}}
                            <div class="space-y-1.5">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700">
                                    <span>Nama Lengkap</span>
                                    <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    required
                                    value="{{ old('name', $user->name) }}"
                                    class="block w-full rounded-lg border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition
                                           focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40
                                           @error('name') border-rose-400 focus:ring-rose-400/40 @enderror"
                                    placeholder="Masukkan nama lengkap kamu"
                                >
                                <p class="text-[11px] text-slate-400">
                                    Nama ini akan tampil di daftar keluhan dan riwayat.
                                </p>
                            </div>

                            {{-- Email --}}
                            <div class="space-y-1.5">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700">
                                    <span>Alamat Email</span>
                                    <span class="text-rose-500">*</span>
                                </label>
                                <input
                                    type="email"
                                    name="email"
                                    required
                                    value="{{ old('email', $user->email) }}"
                                    class="block w-full rounded-lg border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition
                                           focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40
                                           @error('email') border-rose-400 focus:ring-rose-400/40 @enderror"
                                    placeholder="contoh@universitas.ac.id"
                                >
                                <p class="text-[11px] text-slate-400">
                                    Pastikan email aktif, notifikasi bisa dikirim ke sini.
                                </p>
                            </div>

                            {{-- No HP --}}
                            <div class="space-y-1.5">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700">
                                    <span>No. HP</span>
                                </label>
                                <input
                                    type="text"
                                    name="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    class="block w-full rounded-lg border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition
                                           focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40
                                           @error('phone') border-rose-400 focus:ring-rose-400/40 @enderror"
                                    placeholder="Contoh: 08xxxxxxxxxx"
                                >
                                <p class="text-[11px] text-slate-400">
                                    Opsional, tapi membantu jika admin perlu menghubungi kamu.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: PASSWORD --}}
                    <div class="space-y-3 border-t border-slate-100 pt-4">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                Keamanan akun
                            </h2>
                            <span class="text-[11px] text-slate-400">
                                Kosongkan jika tidak ingin mengganti password.
                            </span>
                        </div>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            {{-- Password Baru --}}
                            <div class="space-y-1.5">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700">
                                    <span>Password Baru</span>
                                </label>
                                <input
                                    type="password"
                                    name="password"
                                    class="block w-full rounded-lg border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition
                                           focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40
                                           @error('password') border-rose-400 focus:ring-rose-400/40 @enderror"
                                    placeholder="Minimal 8 karakter"
                                >
                                <p class="text-[11px] text-slate-400">
                                    Isi hanya jika kamu ingin mengganti password.
                                </p>
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="space-y-1.5">
                                <label class="flex items-center gap-1 text-xs font-medium text-slate-700">
                                    <span>Konfirmasi Password Baru</span>
                                </label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="block w-full rounded-lg border border-slate-200 bg-slate-50/60 px-3 py-2 text-sm text-slate-900 shadow-sm outline-none transition
                                           focus:bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40"
                                    placeholder="Ulangi password baru"
                                >
                            </div>
                        </div>
                    </div>

                    {{-- ACTIONS --}}
                    <div class="flex items-center justify-between gap-3 border-t border-slate-100 pt-4">
                        <button
                            type="button"
                            onclick="window.history.back()"
                            class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-medium text-slate-700 shadow-sm transition
                                   hover:bg-slate-50 hover:border-slate-300">
                            ← Kembali
                        </button>

                        <button
                            type="submit"
                            class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-1.5 text-xs font-semibold text-white shadow-sm transition
                                   hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-1">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path d="M6 12.75L10.5 17.25L18 6.75" stroke="currentColor" stroke-width="1.6"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
