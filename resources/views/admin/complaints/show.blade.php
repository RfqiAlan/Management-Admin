<x-app-layout :title="$complaint->title">
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tindak Lanjut Keluhan') }} #{{ $complaint->id }}
            </h2>
            <a href="{{ route('admin.complaints.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- KOLOM KIRI: DETAIL KELUHAN --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white shadow-sm sm:rounded-xl p-6" data-aos="fade-up">
                    <div class="flex justify-between items-start mb-4 border-b pb-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $complaint->title }}</h3>
                            <div class="text-sm text-gray-500 mt-1">
                                Oleh: <span class="font-medium text-gray-800">{{ $complaint->user->name }}</span> 
                                ({{ $complaint->user->email }})
                            </div>
                            <div class="text-sm text-gray-500">
                                Telp: {{ $complaint->user->phone ?? '-' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="px-3 py-1 rounded-full text-xs font-bold inline-block mb-1
                                {{ $complaint->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $complaint->status == 'diproses' ? 'bg-sky-100 text-sky-800' : '' }}
                                {{ $complaint->status == 'selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                {{ $complaint->status == 'ditolak' ? 'bg-rose-100 text-rose-800' : '' }}">
                                {{ strtoupper($complaint->status) }}
                            </div>
                            <div class="text-xs text-gray-400">{{ $complaint->created_at->format('d F Y H:i') }}</div>
                        </div>
                    </div>

                    <div class="prose max-w-none text-gray-700 mb-6">
                        <p class="whitespace-pre-line">{{ $complaint->description }}</p>
                    </div>

                    @if($complaint->evidence_file)
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p class="text-xs font-bold text-gray-500 uppercase mb-2">Bukti Lampiran</p>
                            <a href="{{ asset('storage/' . $complaint->evidence_file) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium text-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat / Download File
                            </a>
                        </div>
                    @endif
                </div>

                {{-- FEEDBACK MAHASISWA (Jika ada) --}}
                @if($complaint->rating)
                    <div class="bg-white shadow-sm sm:rounded-xl p-6 border-l-4 border-yellow-400" data-aos="fade-up">
                        <h3 class="font-bold text-gray-800 mb-2">Ulasan Mahasiswa</h3>
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex text-yellow-400">
                                @for($i=1; $i<=5; $i++)
                                    <span>{{ $i <= $complaint->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <span class="text-sm font-medium text-gray-600">{{ $complaint->rating }}/5.0</span>
                        </div>
                        <p class="text-gray-600 text-sm italic">"{{ $complaint->feedback ?? 'Tidak ada komentar tertulis.' }}"</p>
                    </div>
                @endif

                {{-- HISTORY RESPON --}}
                <div class="bg-white shadow-sm sm:rounded-xl p-6" data-aos="fade-up">
                    <h3 class="font-bold text-gray-800 mb-4">Riwayat Tindak Lanjut</h3>
                    <div class="space-y-6">
                        @forelse($complaint->responses as $resp)
                            <div class="flex gap-4">
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-8 h-8 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center text-xs font-bold">
                                        ADM
                                    </div>
                                </div>
                                <div class="flex-grow bg-gray-50 rounded-lg p-4 border">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="font-semibold text-gray-800 text-sm">{{ $resp->admin->name ?? 'Admin' }}</span>
                                        <span class="text-xs text-gray-400">{{ $resp->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 whitespace-pre-line">{{ $resp->note }}</p>
                                    @if($resp->attachment)
                                        <div class="mt-2 pt-2 border-t border-gray-200">
                                            <a href="{{ asset('storage/'.$resp->attachment) }}" target="_blank" class="text-xs text-indigo-600 hover:underline">Lihat Lampiran Admin</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-400 text-sm py-4">Belum ada respon dari admin.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM AKSI --}}
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm sm:rounded-xl p-6 sticky top-6" data-aos="fade-left">
                    <h3 class="font-bold text-gray-800 mb-4">Update Status & Respon</h3>
                    
                    <form action="{{ route('admin.complaints.respond', $complaint) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <x-input-label value="Update Status" />
                            <select name="status" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                @foreach(['pending','diproses','selesai','ditolak'] as $st)
                                    <option value="{{ $st }}" {{ old('status', $complaint->status) == $st ? 'selected' : '' }}>
                                        {{ ucfirst($st) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label value="Catatan / Balasan" />
                            <textarea name="note" rows="4" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm" placeholder="Tulis pesan untuk mahasiswa..." required>{{ old('note') }}</textarea>
                            <x-input-error :messages="$errors->get('note')" class="mt-1" />
                        </div>

                        <div>
                            <x-input-label value="Lampiran (Opsional)" />
                            <input type="file" name="attachment" class="mt-1 block w-full text-xs text-gray-500 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none">
                            <p class="text-xs text-gray-400 mt-1">Maks 2MB (PDF/IMG).</p>
                        </div>

                        <div class="pt-2">
                            <x-primary-button class="w-full justify-center">
                                {{ __('Kirim Respon & Notif WA') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>