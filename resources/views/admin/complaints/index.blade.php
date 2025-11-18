<x-app-layout title="Kelola Keluhan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Keluhan Mahasiswa') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Filter Section --}}
            <div class="bg-white shadow-sm sm:rounded-xl p-6" data-aos="fade-down">
                <form method="GET" action="{{ route('admin.complaints.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <x-input-label value="Status" class="mb-1" />
                            <select name="status" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                <option value="">Semua Status</option>
                                @foreach(['pending','diproses','selesai','ditolak'] as $st)
                                    <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label value="Tanggal Mulai" class="mb-1" />
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                        </div>
                        <div>
                            <x-input-label value="Tanggal Akhir" class="mb-1" />
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                        </div>
                        <div>
                            <x-input-label value="Cari Mahasiswa" class="mb-1" />
                            <x-text-input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Nama / Email..." class="w-full text-sm" />
                        </div>
                    </div>
                    <div class="mt-4 flex justify-end gap-2">
                        <a href="{{ route('admin.complaints.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                            Reset
                        </a>
                        <x-primary-button>{{ __('Filter Data') }}</x-primary-button>
                    </div>
                </form>
            </div>

            {{-- Table Section --}}
            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden" data-aos="fade-up">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mahasiswa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($complaints as $c)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ Str::limit($c->title, 30) }}</div>
                                        <div class="text-xs text-gray-500">{{ $c->category->name ?? 'Umum' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $c->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $c->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $cls = match($c->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'diproses'=> 'bg-sky-100 text-sky-800',
                                                'selesai' => 'bg-emerald-100 text-emerald-800',
                                                'ditolak' => 'bg-rose-100 text-rose-800',
                                                default => 'bg-gray-100'
                                            };
                                        @endphp
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $cls }}">
                                            {{ ucfirst($c->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $c->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right font-medium">
                                        <a href="{{ route('admin.complaints.show', $c) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data keluhan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $complaints->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>