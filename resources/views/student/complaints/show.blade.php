<x-app-layout :title="$complaint->title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Keluhan
        </h2>
    </x-slot>

    @php
        $status = $complaint->status;
        $statusClasses = match($status) {
            'pending'  => 'bg-yellow-100 text-yellow-800',
            'diproses' => 'bg-sky-100 text-sky-800',
            'selesai'  => 'bg-emerald-100 text-emerald-800',
            'ditolak'  => 'bg-rose-100 text-rose-800',
            default    => 'bg-gray-100 text-gray-800',
        };
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <a href="{{ route('student.complaints.index') }}"
               class="inline-flex items-center text-sm text-gray-600 hover:text-indigo-600">
                &laquo; Kembali ke daftar keluhan
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- KONTEN UTAMA --}}
                <div class="lg:col-span-2 space-y-4">

                    <div class="bg-white shadow-sm sm:rounded-xl p-6">
                        <div class="flex flex-col gap-2 mb-3">
                            <h1 class="text-lg font-semibold text-gray-900">
                                {{ $complaint->title }}
                            </h1>
                            <div class="text-sm text-gray-500">
                                Kategori:
                                <span class="font-medium text-gray-700">
                                    {{ $complaint->category->name ?? '-' }}
                                </span>
                            </div>
                            <div class="flex items-center gap-2 text-sm text-gray-500">
                                <span>Status:</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                    {{ ucfirst($status) }}
                                </span>
                                <span class="text-gray-400">&middot;</span>
                                <span>Dibuat: {{ $complaint->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>

                        <div class="mt-4 text-sm text-gray-800 whitespace-pre-line">
                            {!! nl2br(e($complaint->description)) !!}
                        </div>

                        @if($complaint->evidence_file)
                            <div class="mt-4 border-t border-gray-100 pt-4">
                                <p class="text-sm font-semibold text-gray-700 mb-1">
                                    Bukti Keluhan
                                </p>
                                <a href="{{ asset('storage/' . $complaint->evidence_file) }}" target="_blank"
                                   class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-800">
                                    Lihat Lampiran
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- RATING & FEEDBACK --}}
                    @if($complaint->status === 'selesai')
                        <div class="bg-white shadow-sm sm:rounded-xl p-6 space-y-3">
                            <h2 class="text-sm font-semibold text-gray-800">
                                Rating Kepuasan
                            </h2>

                            @if(session('success'))
                                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-lg px-3 py-2">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-lg px-3 py-2">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form action="{{ route('student.complaints.rate', $complaint) }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-3">
                                @csrf

                                <div class="md:col-span-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Rating (1–5)
                                    </label>
                                    <select name="rating"
                                            class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('rating') border-rose-400 @enderror"
                                            required>
                                        <option value="">- Pilih -</option>
                                        @for($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}" @selected(old('rating', $complaint->rating) == $i)>
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('rating')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Komentar (Opsional)
                                    </label>
                                    <textarea name="feedback" rows="3"
                                              class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('feedback') border-rose-400 @enderror"
                                              placeholder="Tulis komentar singkat...">{{ old('feedback', $complaint->feedback) }}</textarea>
                                    @error('feedback')
                                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-4 flex justify-end">
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                                        Simpan Rating
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                {{-- RIWAYAT TINDAK LANJUT --}}
                <div class="space-y-4">
                    <div class="bg-white shadow-sm sm:rounded-xl p-6">
                        <h2 class="text-sm font-semibold text-gray-800 mb-3">
                            Riwayat Tindak Lanjut
                        </h2>

                        @forelse($complaint->responses as $resp)
                            <div class="pb-3 mb-3 border-b border-gray-100 last:border-none last:mb-0 last:pb-0">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm font-medium text-gray-800">
                                        {{ $resp->admin->name ?? 'Admin' }}
                                    </span>
                                    <span class="text-xs text-gray-500">
                                        {{ $resp->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="mt-1 text-sm text-gray-700 whitespace-pre-line">
                                    {!! nl2br(e($resp->note)) !!}
                                </div>
                                @if($resp->attachment)
                                    <div class="mt-1">
                                        <a href="{{ asset('storage/'.$resp->attachment) }}" target="_blank"
                                           class="text-xs text-indigo-600 hover:text-indigo-800">
                                            Lihat Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">
                                Belum ada tindak lanjut dari admin.
                            </p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
