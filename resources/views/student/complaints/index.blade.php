<x-app-layout title="Keluhan Saya">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Keluhan Saya
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            {{-- Header + tombol --}}
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        Daftar Keluhan
                    </h3>
                    <p class="text-sm text-gray-500">
                        Keluhan yang pernah kamu laporkan ke sistem.
                    </p>
                </div>
                <a href="{{ route('student.complaints.create') }}"
                   class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                    + Keluhan Baru
                </a>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-2">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-lg px-4 py-2">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Tabel --}}
            <div class="bg-white shadow-sm sm:rounded-xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Judul</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rating</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($complaints as $c)
                            @php
                                $status = $c->status;
                                $statusClasses = match($status) {
                                    'pending'  => 'bg-yellow-100 text-yellow-800',
                                    'diproses' => 'bg-sky-100 text-sky-800',
                                    'selesai'  => 'bg-emerald-100 text-emerald-800',
                                    'ditolak'  => 'bg-rose-100 text-rose-800',
                                    default    => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $loop->iteration + ($complaints->currentPage() - 1) * $complaints->perPage() }}
                                </td>
                                <td class="px-4 py-3 text-gray-800">
                                    <div class="font-medium">{{ $c->title }}</div>
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $c->category->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $c->rating ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-gray-700">
                                    {{ $c->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('student.complaints.show', $c) }}"
                                       class="text-indigo-600 hover:text-indigo-800 text-xs font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500">
                                    Belum ada keluhan yang kamu buat.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div>
                {{ $complaints->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
