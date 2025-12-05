<x-admin-layout title="Dashboard" header="Dashboard">
    @php
        $statusArr = is_array($statusCount) ? $statusCount : $statusCount->toArray();
        $totalKeluhan = array_sum($statusArr ?? []);
        $cards = [
            'pending' => ['label' => 'Menunggu', 'icon' => 'fa-clock', 'gradient' => 'from-amber-400 to-orange-500', 'bg' => 'bg-amber-50', 'text' => 'text-amber-600'],
            'diproses' => ['label' => 'Diproses', 'icon' => 'fa-spinner', 'gradient' => 'from-blue-400 to-cyan-500', 'bg' => 'bg-blue-50', 'text' => 'text-blue-600'],
            'selesai' => ['label' => 'Selesai', 'icon' => 'fa-check-circle', 'gradient' => 'from-emerald-400 to-teal-500', 'bg' => 'bg-emerald-50', 'text' => 'text-emerald-600'],
            'ditolak' => ['label' => 'Ditolak', 'icon' => 'fa-times-circle', 'gradient' => 'from-rose-400 to-pink-500', 'bg' => 'bg-rose-50', 'text' => 'text-rose-600'],
        ];
    @endphp

    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 p-8 mb-8 shadow-2xl" data-aos="fade-down">
        <div class="absolute top-0 right-0 -mt-16 -mr-16 w-64 h-64 bg-white/10 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -mb-16 -ml-16 w-48 h-48 bg-white/10 rounded-full"></div>
        <div class="relative z-10">
            <h1 class="text-3xl font-bold text-white mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
            <p class="text-white/80 text-lg">Kelola semua keluhan mahasiswa dengan mudah dan efisien.</p>
            <div class="mt-6 flex flex-wrap gap-4">
                <div class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/70 text-sm">Total Keluhan</p>
                        <p class="text-white text-2xl font-bold">{{ $totalKeluhan }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-xl px-4 py-3">
                    <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center">
                        <i class="fas fa-star text-yellow-300 text-xl"></i>
                    </div>
                    <div>
                        <p class="text-white/70 text-sm">Rating Rata-rata</p>
                        <p class="text-white text-2xl font-bold">{{ $avgRating ? number_format($avgRating, 1) : '-' }}<span class="text-sm font-normal">/5</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($cards as $key => $meta)
            @php
                $jumlah = $statusArr[$key] ?? 0;
                $percent = $totalKeluhan > 0 ? ($jumlah / $totalKeluhan) * 100 : 0;
            @endphp
            <div class="stat-card bg-white rounded-2xl p-6 shadow-xl hover:shadow-2xl transition-all duration-300 group" 
                 data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $meta['gradient'] }} flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas {{ $meta['icon'] }} text-white text-xl"></i>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $meta['bg'] }} {{ $meta['text'] }}">
                        {{ number_format($percent, 0) }}%
                    </span>
                </div>
                <div>
                    <p class="text-gray-500 text-sm font-medium">{{ $meta['label'] }}</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $jumlah }}</p>
                </div>
                <div class="mt-4 h-2 bg-gray-100 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r {{ $meta['gradient'] }} rounded-full transition-all duration-500" 
                         style="width: {{ $percent }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Charts & Data Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Tren Keluhan -->
        <div class="glass-card rounded-2xl p-6" data-aos="fade-right">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Tren Keluhan</h3>
                    <p class="text-sm text-gray-400">Data keluhan per bulan</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                    <i class="fas fa-chart-bar text-indigo-500"></i>
                </div>
            </div>
            @if($perMonth->isNotEmpty())
                <div class="space-y-4">
                    @foreach($perMonth as $row)
                        @php
                            $maxTotal = $perMonth->max('total');
                            $barWidth = $maxTotal > 0 ? ($row->total / $maxTotal) * 100 : 0;
                        @endphp
                        <div class="flex items-center gap-4">
                            <div class="w-24 text-sm text-gray-600 font-medium">{{ $row->month }}</div>
                            <div class="flex-1 h-10 bg-gray-100 rounded-xl overflow-hidden relative">
                                <div class="absolute inset-y-0 left-0 bg-gradient-to-r from-indigo-500 to-purple-500 rounded-xl flex items-center justify-end pr-3 transition-all duration-500" 
                                     style="width: {{ $barWidth }}%">
                                    <span class="text-white text-sm font-bold">{{ $row->total }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                    <i class="fas fa-chart-bar text-4xl mb-3 opacity-50"></i>
                    <p>Belum ada data tren</p>
                </div>
            @endif
        </div>

        <!-- Top Kategori -->
        <div class="glass-card rounded-2xl p-6" data-aos="fade-left">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Top Kategori</h3>
                    <p class="text-sm text-gray-400">Kategori paling banyak dilaporkan</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center">
                    <i class="fas fa-folder-open text-purple-500"></i>
                </div>
            </div>
            @if($topCategories->isNotEmpty())
                <div class="space-y-4">
                    @foreach($topCategories as $index => $row)
                        @php
                            $colors = ['from-indigo-500 to-purple-500', 'from-pink-500 to-rose-500', 'from-amber-500 to-orange-500', 'from-emerald-500 to-teal-500', 'from-blue-500 to-cyan-500'];
                            $bgColors = ['bg-indigo-50 text-indigo-600', 'bg-pink-50 text-pink-600', 'bg-amber-50 text-amber-600', 'bg-emerald-50 text-emerald-600', 'bg-blue-50 text-blue-600'];
                        @endphp
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition group">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $colors[$index % 5] }} flex items-center justify-center text-white font-bold">
                                {{ $index + 1 }}
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-800">{{ $row->category->name ?? 'Tidak Berkategori' }}</p>
                                <p class="text-sm text-gray-400">Total laporan</p>
                            </div>
                            <div class="px-4 py-2 rounded-xl {{ $bgColors[$index % 5] }} font-bold">
                                {{ $row->total }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12 text-gray-400">
                    <i class="fas fa-folder-open text-4xl mb-3 opacity-50"></i>
                    <p>Belum ada data kategori</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up">
        <a href="{{ route('admin.complaints.index') }}" class="group p-6 rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all border border-gray-100 hover:border-indigo-200">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-indigo-500/30">
                <i class="fas fa-list-alt text-white text-xl"></i>
            </div>
            <h4 class="font-bold text-gray-800 mb-1">Lihat Semua Keluhan</h4>
            <p class="text-sm text-gray-400">Kelola dan tanggapi keluhan mahasiswa</p>
        </a>
        
        <a href="{{ route('admin.users.index') }}" class="group p-6 rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all border border-gray-100 hover:border-purple-200">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-purple-500 to-pink-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-purple-500/30">
                <i class="fas fa-users text-white text-xl"></i>
            </div>
            <h4 class="font-bold text-gray-800 mb-1">Kelola Mahasiswa</h4>
            <p class="text-sm text-gray-400">Lihat dan kelola data mahasiswa</p>
        </a>
        
        <a href="{{ route('admin.categories.index') }}" class="group p-6 rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all border border-gray-100 hover:border-pink-200">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform shadow-lg shadow-pink-500/30">
                <i class="fas fa-tags text-white text-xl"></i>
            </div>
            <h4 class="font-bold text-gray-800 mb-1">Kelola Kategori</h4>
            <p class="text-sm text-gray-400">Tambah dan edit kategori keluhan</p>
        </a>
    </div>
</x-admin-layout>
