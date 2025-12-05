<x-admin-layout title="Kelola Keluhan" header="Kelola Keluhan">
    <!-- Page Header -->
    <div class="mb-6" data-aos="fade-down">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Daftar Keluhan Mahasiswa</h1>
                <p class="text-gray-500">Kelola dan tanggapi semua keluhan yang masuk</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl">
                <i class="fas fa-inbox"></i>
                <span class="font-semibold">{{ $complaints->total() }} Keluhan</span>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="glass-card rounded-2xl p-6 mb-6" data-aos="fade-up">
        <form method="GET" action="{{ route('admin.complaints.index') }}">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <!-- Status Filter -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-filter mr-1 text-indigo-500"></i>Status
                    </label>
                    <select name="status" class="block w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                        <option value="">Semua Status</option>
                        @foreach(['pending' => 'Menunggu', 'diproses' => 'Diproses', 'selesai' => 'Selesai', 'ditolak' => 'Ditolak'] as $val => $label)
                            <option value="{{ $val }}" {{ request('status') == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date From -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-1 text-indigo-500"></i>Dari Tanggal
                    </label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="block w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                </div>

                <!-- Date To -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar-check mr-1 text-indigo-500"></i>Sampai Tanggal
                    </label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}" 
                           class="block w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                </div>

                <!-- Search -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-search mr-1 text-indigo-500"></i>Cari
                    </label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" 
                           placeholder="Nama / Email..."
                           class="block w-full px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all">
                </div>

                <!-- Buttons -->
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 px-4 py-2.5 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                    <a href="{{ route('admin.complaints.index') }}" class="px-4 py-2.5 bg-gray-200 text-gray-600 rounded-xl font-semibold hover:bg-gray-300 transition-all">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="glass-card rounded-2xl overflow-hidden" data-aos="fade-up" data-aos-delay="100">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Keluhan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($complaints as $c)
                        @php
                            $statusConfig = match($c->status) {
                                'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-700', 'icon' => 'fa-clock'],
                                'diproses' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-700', 'icon' => 'fa-spinner'],
                                'selesai' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-700', 'icon' => 'fa-check-circle'],
                                'ditolak' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-700', 'icon' => 'fa-times-circle'],
                                default => ['bg' => 'bg-gray-100', 'text' => 'text-gray-700', 'icon' => 'fa-question'],
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-comment-dots text-indigo-500"></i>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ Str::limit($c->title, 35) }}</p>
                                        <p class="text-sm text-gray-500">{{ $c->category->name ?? 'Umum' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center text-white text-xs font-semibold flex-shrink-0">
                                        {{ strtoupper(substr($c->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $c->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $c->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold {{ $statusConfig['bg'] }} {{ $statusConfig['text'] }}">
                                    <i class="fas {{ $statusConfig['icon'] }}"></i>
                                    {{ ucfirst($c->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-800">{{ $c->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $c->created_at->format('H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.complaints.show', $c) }}" 
                                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-medium hover:bg-indigo-100 transition-colors">
                                    <i class="fas fa-eye"></i>
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-inbox text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data keluhan</p>
                                    <p class="text-sm text-gray-400">Coba ubah filter pencarian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($complaints->hasPages())
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                {{ $complaints->withQueryString()->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
