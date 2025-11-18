<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Keluhan') }} #{{ $complaint->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="md:col-span-2 space-y-6">
                    
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" data-aos="fade-up">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold 
                                    {{ $complaint->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $complaint->status == 'diproses' ? 'bg-sky-100 text-sky-800' : '' }}
                                    {{ $complaint->status == 'selesai' ? 'bg-emerald-100 text-emerald-800' : '' }}
                                    {{ $complaint->status == 'ditolak' ? 'bg-rose-100 text-rose-800' : '' }}">
                                    {{ strtoupper($complaint->status) }}
                                </span>
                                <h3 class="text-2xl font-bold text-gray-800 mt-2">{{ $complaint->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $complaint->created_at->translatedFormat('l, d F Y H:i') }}</p>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-500 uppercase tracking-wider">Kategori</div>
                                <div class="font-semibold text-indigo-600">{{ $complaint->category->name ?? 'Umum' }}</div>
                            </div>
                        </div>

                        <div class="prose max-w-none text-gray-700 mb-6">
                            {{-- Gunakan nl2br agar enter terbaca --}}
                            <p>{!! nl2br(e($complaint->description)) !!}</p>
                        </div>

                        @if($complaint->evidence_file)
                            <div class="mt-4 border-t pt-4">
                                <h4 class="text-sm font-semibold text-gray-800 mb-2">Bukti Lampiran:</h4>
                                <a href="{{ asset('storage/' . $complaint->evidence_file) }}" target="_blank" class="inline-flex items-center text-indigo-600 hover:underline">
                                    Lihat File Bukti
                                </a>
                            </div>
                        @endif
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" data-aos="fade-up" data-aos-delay="100">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Tindak Lanjut & Respon Admin</h3>
                        
                        <div class="space-y-6">
                            {{-- Debugging: Cek apakah ada respon --}}
                            @if($complaint->responses->isEmpty())
                                <div class="text-center text-gray-500 py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                    <p class="text-sm italic">Belum ada respon atau tindak lanjut dari admin.</p>
                                </div>
                            @else
                                @foreach($complaint->responses as $response)
                                    <div class="flex gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm">
                                                ADM
                                            </div>
                                        </div>
                                        <div class="flex-grow bg-gray-50 rounded-lg p-4 shadow-sm border border-gray-100">
                                            <div class="flex justify-between items-center mb-2">
                                                <span class="font-semibold text-gray-900 text-sm">{{ $response->admin->name ?? 'Administrator' }}</span>
                                                <span class="text-xs text-gray-500">{{ $response->created_at->diffForHumans() }}</span>
                                            </div>
                                            
                                            {{-- INI YANG PENTING: note --}}
                                            <div class="text-gray-800 text-sm whitespace-pre-line">{{ $response->note }}</div>

                                            @if($response->attachment)
                                                <div class="mt-3 pt-2 border-t border-gray-200">
                                                    <a href="{{ asset('storage/' . $response->attachment) }}" target="_blank" class="inline-flex items-center text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                                        Lihat Lampiran Admin
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="md:col-span-1 space-y-6">
                    <div class="bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider mb-3">Status</h3>
                        <div class="flex items-center">
                             <div class="w-3 h-3 rounded-full mr-2 
                                {{ $complaint->status == 'selesai' ? 'bg-emerald-500' : ($complaint->status == 'ditolak' ? 'bg-rose-500' : 'bg-yellow-500') }}"></div>
                             <span class="font-medium text-gray-900 capitalize">{{ $complaint->status }}</span>
                        </div>
                    </div>

                    @if($complaint->status == 'selesai')
                        <div class="bg-white shadow-sm sm:rounded-lg p-6 border-t-4 border-emerald-500">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Beri Rating</h3>
                            @if($complaint->rating)
                                <div class="text-3xl text-yellow-400 font-bold text-center">
                                    @for($i=1; $i<=5; $i++) {{ $i <= $complaint->rating ? '★' : '☆' }} @endfor
                                </div>
                                <p class="text-center text-sm text-gray-600 mt-1">"{{ $complaint->feedback }}"</p>
                            @else
                                <form action="{{ route('student.complaints.rate', $complaint) }}" method="POST">
                                    @csrf
                                    <div class="flex justify-center gap-1 text-2xl text-gray-300 mb-4">
                                        @for($i=1; $i<=5; $i++)
                                            <label class="cursor-pointer hover:text-yellow-400">
                                                <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" onchange="this.parentElement.parentElement.querySelectorAll('label').forEach((l, idx) => l.style.color = idx < {{ $i }} ? '#facc15' : '#d1d5db')">
                                                ★
                                            </label>
                                        @endfor
                                    </div>
                                    <textarea name="feedback" rows="2" class="w-full text-sm border-gray-300 rounded-md mb-2" placeholder="Masukan..."></textarea>
                                    <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded-md text-sm">Kirim</button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</x-app-layout>