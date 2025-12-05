<x-student-layout title="Detail Keluhan #{{ $complaint->id }}">
    @php
        $statusConfig = match($complaint->status) {
            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'fa-clock', 'gradient' => 'from-amber-400 to-orange-500', 'label' => 'Menunggu'],
            'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-spinner', 'gradient' => 'from-blue-400 to-cyan-500', 'label' => 'Sedang Diproses'],
            'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'fa-check-circle', 'gradient' => 'from-emerald-400 to-teal-500', 'label' => 'Selesai'],
            'ditolak' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'icon' => 'fa-times-circle', 'gradient' => 'from-rose-400 to-pink-500', 'label' => 'Ditolak'],
            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-question', 'gradient' => 'from-gray-400 to-gray-500', 'label' => 'Unknown'],
        };
    @endphp

    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-right">
        <a href="{{ route('student.complaints.index') }}" 
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Complaint Detail Card -->
            <div class="glass-card overflow-hidden" data-aos="fade-up">
                <!-- Header with Status -->
                <div class="p-6 bg-gradient-to-r {{ $statusConfig['gradient'] }}">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-sm text-white text-sm font-medium mb-2">
                                <i class="fas {{ $statusConfig['icon'] }}"></i>
                                {{ $statusConfig['label'] }}
                            </span>
                            <h1 class="text-2xl font-bold text-white">{{ $complaint->title }}</h1>
                        </div>
                        <div class="text-white/80 text-sm">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $complaint->created_at->translatedFormat('d F Y, H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Body -->
                <div class="p-6">
                    <div class="flex items-center gap-3 mb-4 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                            <i class="fas fa-folder text-indigo-500"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Kategori</p>
                            <p class="font-semibold text-gray-800">{{ $complaint->category->name ?? 'Umum' }}</p>
                        </div>
                    </div>

                    <div class="prose max-w-none">
                        <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Deskripsi</h4>
                        <div class="text-gray-700 whitespace-pre-line bg-gray-50 rounded-xl p-4">
                            {{ $complaint->description }}
                        </div>
                    </div>

                    @if($complaint->evidence_file)
                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Bukti Lampiran</h4>
                            <a href="{{ asset('storage/' . $complaint->evidence_file) }}" target="_blank" 
                               class="inline-flex items-center gap-2 px-4 py-3 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors">
                                <i class="fas fa-file-download"></i>
                                <span class="font-medium">Lihat File Bukti</span>
                                <i class="fas fa-external-link-alt text-xs"></i>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Responses Section -->
            <div class="glass-card p-6" data-aos="fade-up" data-aos-delay="100">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-purple-100 to-pink-100 flex items-center justify-center">
                        <i class="fas fa-comments text-purple-500"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Tindak Lanjut & Respon</h3>
                        <p class="text-sm text-gray-500">Respon dari admin terkait keluhan kamu</p>
                    </div>
                </div>

                @if($complaint->responses->isEmpty())
                    <div class="text-center py-12 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class="fas fa-inbox text-2xl text-gray-400"></i>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada respon dari admin</p>
                        <p class="text-sm text-gray-400">Keluhan kamu sedang dalam antrian untuk ditinjau</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($complaint->responses as $response)
                            <div class="flex gap-4 p-4 rounded-xl bg-gradient-to-r from-indigo-50/50 to-purple-50/50 border border-indigo-100">
                                <div class="flex-shrink-0">
                                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold shadow-lg">
                                        <i class="fas fa-user-shield"></i>
                                    </div>
                                </div>
                                <div class="flex-grow">
                                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-2">
                                        <span class="font-semibold text-gray-800">{{ $response->admin->name ?? 'Administrator' }}</span>
                                        <span class="text-xs text-gray-500 flex items-center gap-1">
                                            <i class="fas fa-clock"></i>
                                            {{ $response->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="text-gray-700 whitespace-pre-line">{{ $response->note }}</div>

                                    @if($response->attachment)
                                        <div class="mt-3 pt-3 border-t border-indigo-100">
                                            <a href="{{ asset('storage/' . $response->attachment) }}" target="_blank" 
                                               class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                                                <i class="fas fa-paperclip"></i>
                                                Lihat Lampiran Admin
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

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="glass-card p-6" data-aos="fade-left">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Status Keluhan</h3>
                <div class="flex items-center gap-3 p-4 rounded-xl bg-gradient-to-r {{ $statusConfig['gradient'] }}">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                        <i class="fas {{ $statusConfig['icon'] }} text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/80 text-sm">Status Saat Ini</p>
                        <p class="text-white font-bold text-lg">{{ $statusConfig['label'] }}</p>
                    </div>
                </div>

                <!-- Progress Steps -->
                <div class="mt-6 space-y-4">
                    @php
                        $steps = ['pending' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai'];
                        $currentStep = array_search($complaint->status, array_keys($steps));
                        if ($complaint->status === 'ditolak') $currentStep = 1;
                    @endphp
                    @foreach($steps as $key => $label)
                        @php
                            $stepIndex = array_search($key, array_keys($steps));
                            $isCompleted = $stepIndex < $currentStep || ($key === $complaint->status && $key === 'selesai');
                            $isCurrent = $key === $complaint->status;
                            $isRejected = $complaint->status === 'ditolak' && $key === 'diproses';
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                {{ $isCompleted ? 'bg-emerald-500 text-white' : ($isCurrent ? 'bg-indigo-500 text-white' : ($isRejected ? 'bg-rose-500 text-white' : 'bg-gray-200 text-gray-400')) }}">
                                @if($isCompleted)
                                    <i class="fas fa-check text-sm"></i>
                                @elseif($isRejected)
                                    <i class="fas fa-times text-sm"></i>
                                @else
                                    <span class="text-sm font-medium">{{ $stepIndex + 1 }}</span>
                                @endif
                            </div>
                            <span class="text-sm {{ $isCurrent || $isCompleted ? 'font-semibold text-gray-800' : 'text-gray-400' }}">
                                {{ $isRejected ? 'Ditolak' : $label }}
                            </span>
                        </div>
                        @if(!$loop->last)
                            <div class="ml-4 w-px h-4 {{ $stepIndex < $currentStep ? 'bg-emerald-500' : 'bg-gray-200' }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Rating Card -->
            @if($complaint->status == 'selesai')
                <div class="glass-card p-6 border-t-4 border-emerald-500" data-aos="fade-left" data-aos-delay="100">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center shadow-lg">
                            <i class="fas fa-star text-white"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800">Beri Rating</h3>
                            <p class="text-xs text-gray-500">Bantu kami tingkatkan layanan</p>
                        </div>
                    </div>

                    @if($complaint->rating)
                        <div class="text-center p-4 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl">
                            <div class="flex justify-center gap-1 text-3xl mb-2">
                                @for($i=1; $i<=5; $i++)
                                    <i class="fas fa-star {{ $i <= $complaint->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <p class="text-2xl font-bold text-gray-800">{{ $complaint->rating }}/5</p>
                            @if($complaint->feedback)
                                <div class="mt-3 p-3 bg-white rounded-lg">
                                    <p class="text-sm text-gray-600 italic">"{{ $complaint->feedback }}"</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <form action="{{ route('student.complaints.rate', $complaint) }}" method="POST" x-data="{ rating: 0, hoverRating: 0 }">
                            @csrf
                            <div class="flex justify-center gap-2 mb-4">
                                @for($i=1; $i<=5; $i++)
                                    <button type="button" 
                                            @click="rating = {{ $i }}" 
                                            @mouseenter="hoverRating = {{ $i }}"
                                            @mouseleave="hoverRating = 0"
                                            class="text-3xl transition-transform hover:scale-125 focus:outline-none">
                                        <i class="fas fa-star" :class="(hoverRating || rating) >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'"></i>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" :value="rating">
                            <textarea name="feedback" rows="3" 
                                      placeholder="Berikan masukan untuk kami (opsional)..."
                                      class="w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all resize-none mb-4"></textarea>
                            <button type="submit" 
                                    :disabled="rating === 0"
                                    class="w-full px-4 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Kirim Rating
                            </button>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Quick Info -->
            <div class="glass-card p-6" data-aos="fade-left" data-aos-delay="200">
                <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-4">Informasi</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">ID Keluhan</span>
                        <span class="font-mono font-semibold text-gray-800">#{{ $complaint->id }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Dibuat</span>
                        <span class="text-gray-800">{{ $complaint->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Terakhir Update</span>
                        <span class="text-gray-800">{{ $complaint->updated_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-student-layout>
