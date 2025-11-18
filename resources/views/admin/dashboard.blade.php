<x-app-layout title="Dashboard Admin">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" data-aos="fade-right">
            {{ __('Dashboard Keluhan Mahasiswa') }}
        </h2>
    </x-slot>

    @php
        $statusArr = is_array($statusCount) ? $statusCount : $statusCount->toArray();
        $totalKeluhan = array_sum($statusArr ?? []);
        $cards = [
            'pending' => ['label' => 'Menunggu', 'color' => 'bg-yellow-100 text-yellow-800', 'bar' => 'bg-yellow-400'],
            'diproses' => ['label' => 'Diproses', 'color' => 'bg-sky-100 text-sky-800', 'bar' => 'bg-sky-400'],
            'selesai' => ['label' => 'Selesai', 'color' => 'bg-emerald-100 text-emerald-800', 'bar' => 'bg-emerald-400'],
            'ditolak' => ['label' => 'Ditolak', 'color' => 'bg-rose-100 text-rose-800', 'bar' => 'bg-rose-400'],
        ];
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- RINGKASAN --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-6" data-aos="fade-up">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">Ringkasan Keluhan</h3>
                        <p class="text-sm text-gray-500">Status keluhan, performa penanganan, dan tingkat kepuasan.</p>
                    </div>
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-indigo-600">{{ $avgRating ? number_format($avgRating, 2) : '-' }}</span>
                        <span class="text-sm text-gray-500">/ 5.00 &middot; Rata-rata rating</span>
                    </div>
                </div>
            </div>

            {{-- KARTU STATUS --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($cards as $key => $meta)
                    @php
                        $jumlah  = $statusArr[$key] ?? 0;
                        $percent = $totalKeluhan > 0 ? ($jumlah / $totalKeluhan) * 100 : 0;
                    @endphp
                    <div class="bg-white shadow-sm rounded-xl p-5 flex flex-col gap-3 transform hover:scale-105 transition duration-300" 
                         data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-medium text-gray-500">{{ $meta['label'] }}</p>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $meta['color'] }}">
                                {{ ucfirst($key) }}
                            </span>
                        </div>
                        <div class="text-3xl font-semibold text-gray-900">{{ $jumlah }}</div>
                        <div class="h-2 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full {{ $meta['bar'] }} rounded-full" style="width: {{ $percent }}%;"></div>
                        </div>
                        <p class="text-xs text-gray-500">{{ $totalKeluhan }} total &middot; {{ number_format($percent, 0) }}%</p>
                    </div>
                @endforeach
            </div>

            {{-- DETAIL BAWAH --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- TREN --}}
                <div class="bg-white shadow-sm rounded-xl p-5 flex flex-col gap-3" data-aos="fade-right" data-aos-delay="300">
                    <h3 class="text-sm font-semibold text-gray-800">Tren Keluhan per Bulan</h3>
                    @if($perMonth->isNotEmpty())
                        <ul class="divide-y divide-gray-100 text-sm">
                            @foreach($perMonth as $row)
                                <li class="flex items-center justify-between py-3">
                                    <span class="font-medium text-gray-700">{{ $row->month }}</span>
                                    <span class="text-indigo-600 font-bold bg-indigo-50 px-2 py-1 rounded-md">{{ $row->total }} Keluhan</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-gray-500 text-sm py-4">Belum ada data.</p>
                    @endif
                </div>

                {{-- KATEGORI TERBANYAK --}}
                <div class="bg-white shadow-sm rounded-xl p-5 flex flex-col gap-3" data-aos="fade-left" data-aos-delay="300">
                    <h3 class="text-sm font-semibold text-gray-800">Top Kategori Masalah</h3>
                    @if($topCategories->isNotEmpty())
                        <ul class="divide-y divide-gray-100 text-sm">
                            @foreach($topCategories as $row)
                                <li class="flex items-center justify-between py-3">
                                    <span class="font-medium text-gray-700">{{ $row->category->name ?? '-' }}</span>
                                    <span class="text-emerald-600 font-bold bg-emerald-50 px-2 py-1 rounded-md">{{ $row->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-gray-500 text-sm py-4">Belum ada data.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>