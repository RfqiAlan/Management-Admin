<x-student-layout title="Dashboard Keluhan">
    @php
        $totalKeluhan = $complaints->total();
        $statusCounts = [
            'pending' => $complaints->where('status', 'pending')->count(),
            'diproses' => $complaints->where('status', 'diproses')->count(),
            'selesai' => $complaints->where('status', 'selesai')->count(),
            'ditolak' => $complaints->where('status', 'ditolak')->count(),
        ];
    @endphp

    <!-- Welcome Section -->
    <div class="mb-8" data-aos="fade-down">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 shadow-2xl">
            <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-white/10 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 bg-white/10 rounded-full"></div>
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">Hai, {{ auth()->user()->name }}! 👋</h1>
                    <p class="text-white/80">Kelola dan pantau semua keluhan kamu di sini.</p>
                </div>
                <a href="{{ route('student.complaints.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-white rounded-xl text-indigo-600 font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <i class="fas fa-plus-circle"></i>
                    <span>Buat Keluhan Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="glass-card p-5 group hover:scale-105 transition-all" data-aos="fade-up" data-aos-delay="100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-400 to-orange-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-clock text-white"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $statusCounts['pending'] }}</p>
                    <p class="text-sm text-gray-500">Menunggu</p>
                </div>
            </div>
        </div>
        <div class="glass-card p-5 group hover:scale-105 transition-all" data-aos="fade-up" data-aos-delay="200">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-blue-400 to-cyan-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-spinner text-white"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $statusCounts['diproses'] }}</p>
                    <p class="text-sm text-gray-500">Diproses</p>
                </div>
            </div>
        </div>
        <div class="glass-card p-5 group hover:scale-105 transition-all" data-aos="fade-up" data-aos-delay="300">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-check-circle text-white"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $statusCounts['selesai'] }}</p>
                    <p class="text-sm text-gray-500">Selesai</p>
                </div>
            </div>
        </div>
        <div class="glass-card p-5 group hover:scale-105 transition-all" data-aos="fade-up" data-aos-delay="400">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-rose-400 to-pink-500 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                    <i class="fas fa-times-circle text-white"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800">{{ $statusCounts['ditolak'] }}</p>
                    <p class="text-sm text-gray-500">Ditolak</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Complaints List -->
    <div class="glass-card overflow-hidden" data-aos="fade-up">
        <div class="p-6 border-b border-gray-100">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Daftar Keluhan Saya</h2>
                    <p class="text-sm text-gray-500">Total {{ $complaints->total() }} keluhan</p>
                </div>
            </div>
        </div>

        @if($complaints->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach($complaints as $c)
                    @php
                        $statusConfig = match($c->status) {
                            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'fa-clock', 'gradient' => 'from-amber-400 to-orange-500'],
                            'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-spinner fa-spin', 'gradient' => 'from-blue-400 to-cyan-500'],
                            'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'fa-check-circle', 'gradient' => 'from-emerald-400 to-teal-500'],
                            'ditolak' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'icon' => 'fa-times-circle', 'gradient' => 'from-rose-400 to-pink-500'],
                            default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-question', 'gradient' => 'from-gray-400 to-gray-500'],
                        };
                    @endphp
                    <a href="{{ route('student.complaints.show', $c) }}" 
                       class="block p-6 hover:bg-gray-50/50 transition-colors group">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                            <!-- Status Icon -->
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-br {{ $statusConfig['gradient'] }} flex items-center justify-center shadow-lg flex-shrink-0 group-hover:scale-110 transition-transform">
                                <i class="fas {{ $statusConfig['icon'] }} text-white"></i>
                            </div>
                            
                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-1">
                                    <h3 class="font-semibold text-gray-800 truncate group-hover:text-indigo-600 transition-colors">
                                        {{ $c->title }}
                                    </h3>
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }} w-fit">
                                        <i class="fas {{ $statusConfig['icon'] }} text-xs"></i>
                                        {{ ucfirst($c->status) }}
                                    </span>
                                </div>
                                <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-folder text-gray-400"></i>
                                        {{ $c->category->name ?? 'Umum' }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-calendar text-gray-400"></i>
                                        {{ $c->created_at->format('d M Y') }}
                                    </span>
                                    @if($c->rating)
                                        <span class="flex items-center gap-1">
                                            <i class="fas fa-star text-yellow-400"></i>
                                            {{ $c->rating }}/5
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Arrow -->
                            <div class="hidden sm:flex items-center">
                                <i class="fas fa-chevron-right text-gray-300 group-hover:text-indigo-500 group-hover:translate-x-1 transition-all"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="p-6 bg-gray-50/50 border-t border-gray-100">
                {{ $complaints->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                    <i class="fas fa-inbox text-4xl text-indigo-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Keluhan</h3>
                <p class="text-gray-500 mb-6">Kamu belum pernah membuat keluhan. Yuk buat keluhan pertamamu!</p>
                <a href="{{ route('student.complaints.create') }}" 
                   class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <i class="fas fa-plus-circle"></i>
                    <span>Buat Keluhan Baru</span>
                </a>
            </div>
        @endif
    </div>
</x-student-layout>
