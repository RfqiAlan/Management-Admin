<x-admin-layout title="Detail Keluhan #{{ $complaint->id }}" header="Detail Keluhan">
    @php
        $statusConfig = match($complaint->status) {
            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'fa-clock', 'gradient' => 'from-amber-400 to-orange-500'],
            'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-spinner', 'gradient' => 'from-blue-400 to-cyan-500'],
            'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'fa-check-circle', 'gradient' => 'from-emerald-400 to-teal-500'],
            'ditolak' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'icon' => 'fa-times-circle', 'gradient' => 'from-rose-400 to-pink-500'],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-question', 'gradient' => 'from-gray-400 to-gray-500'],
        };
    @endphp

    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-right">
        <a href="{{ route('admin.complaints.index') }}" 
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Daftar Keluhan</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Complaint Card -->
            <div class="glass-card rounded-2xl overflow-hidden" data-aos="fade-up">
                <div class="p-6 bg-gradient-to-r {{ $statusConfig['gradient'] }}">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                        <div>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium mb-3">
                                <i class="fas {{ $statusConfig['icon'] }}"></i>
                                {{ ucfirst($complaint->status) }}
                            </span>
                            <h1 class="text-2xl font-bold text-white mb-2">{{ $complaint->title }}</h1>
                            <p class="text-white/80 text-sm">
                                <i class="fas fa-folder mr-1"></i>
                                {{ $complaint->category->name ?? 'Umum' }}
                            </p>
                        </div>
                        <div class="text-white/80 text-sm">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $complaint->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <!-- User Info -->
                    <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl mb-6">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xl font-bold shadow-lg">
                            {{ strtoupper(substr($complaint->user->name, 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-800">{{ $complaint->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $complaint->user->email }}</p>
                            <p class="text-sm text-gray-500">
                                <i class="fas fa-phone mr-1"></i>
                                {{ $complaint->user->phone ?? 'Tidak ada nomor telepon' }}
                            </p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Deskripsi Keluhan</h4>
                        <div class="p-4 bg-gray-50 rounded-xl text-gray-700 whitespace-pre-line">
                            {{ $complaint->description }}
                        </div>
                    </div>

                    <!-- Evidence -->
                    @if($complaint->evidence_file)
                        <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100">
                            <h4 class="text-sm font-bold text-indigo-800 mb-2">
                                <i class="fas fa-paperclip mr-1"></i>
                                Bukti Lampiran
                            </h4>
                            <a href="{{ asset('storage/' . $complaint->evidence_file) }}" target="_blank" 
                               class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium">
                                <i class="fas fa-file-download"></i>
                                Lihat / Download File
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Feedback from Student -->
            @if($complaint->rating)
                <div class="glass-card rounded-2xl p-6 border-l-4 border-yellow-400" data-aos="fade-up">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Ulasan dari Mahasiswa</h3>
                            <p class="text-sm text-gray-500">Feedback setelah keluhan selesai</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="flex text-yellow-400 text-xl">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star {{ $i <= $complaint->rating ? '' : 'opacity-30' }}"></i>
                            @endfor
                        </div>
                        <span class="text-lg font-bold text-gray-800">{{ $complaint->rating }}/5</span>
                    </div>
                    @if($complaint->feedback)
                        <p class="text-gray-600 italic bg-gray-50 p-3 rounded-lg">"{{ $complaint->feedback }}"</p>
                    @endif
                </div>
            @endif

            <!-- Response History -->
            <div class="glass-card rounded-2xl p-6" data-aos="fade-up">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-400 to-pink-500 flex items-center justify-center shadow-lg">
                        <i class="fas fa-history text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Riwayat Tindak Lanjut</h3>
                        <p class="text-sm text-gray-500">Semua respon yang telah diberikan</p>
                    </div>
                </div>

                @if($complaint->responses->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-inbox text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada respon</p>
                        <p class="text-sm text-gray-400">Gunakan form di samping untuk memberikan respon</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($complaint->responses as $resp)
                            <div class="flex gap-4 p-4 bg-gradient-to-r from-indigo-50/50 to-purple-50/50 rounded-xl border border-indigo-100">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold flex-shrink-0">
                                    {{ strtoupper(substr($resp->admin->name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                        <span class="font-semibold text-gray-800">{{ $resp->admin->name ?? 'Admin' }}</span>
                                        <span class="text-xs text-gray-500">{{ $resp->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <p class="text-gray-700 whitespace-pre-line">{{ $resp->note }}</p>
                                    @if($resp->attachment)
                                        <div class="mt-3 pt-3 border-t border-indigo-100">
                                            <a href="{{ asset('storage/'.$resp->attachment) }}" target="_blank" 
                                               class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800">
                                                <i class="fas fa-paperclip"></i>
                                                Lihat Lampiran
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar - Action Form -->
        <div class="lg:col-span-1">
            <div class="glass-card rounded-2xl p-6 sticky top-6" data-aos="fade-left">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg">
                        <i class="fas fa-reply text-white"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Tindak Lanjut</h3>
                        <p class="text-xs text-gray-500">Update status & kirim respon</p>
                    </div>
                </div>

                <form action="{{ route('admin.complaints.respond', $complaint) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-exchange-alt mr-1 text-indigo-500"></i>
                            Update Status
                        </label>
                        <select name="status" 
                                class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                            @foreach(['pending' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
                                <option value="{{ $val }}" {{ old('status', $complaint->status) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-comment mr-1 text-indigo-500"></i>
                            Catatan / Balasan
                        </label>
                        <textarea name="note" rows="4" required
                                  placeholder="Tulis pesan untuk mahasiswa..."
                                  class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all resize-none">{{ old('note') }}</textarea>
                        @error('note')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Attachment -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-paperclip mr-1 text-indigo-500"></i>
                            Lampiran (Opsional)
                        </label>
                        <input type="file" name="attachment" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 cursor-pointer">
                        <p class="text-xs text-gray-400 mt-2">Maks 2MB (PDF/IMG)</p>
                    </div>

                    <!-- Submit -->
                    <button type="submit" 
                            class="w-full px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Respon & Notif WA
                    </button>
                </form>

                <!-- Quick Info -->
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-3">Informasi Keluhan</h4>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-500">ID</span>
                            <span class="font-mono font-semibold">#{{ $complaint->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Dibuat</span>
                            <span>{{ $complaint->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Respon</span>
                            <span>{{ $complaint->responses->count() }} kali</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
