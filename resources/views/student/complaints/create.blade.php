<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Keluhan Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4" data-aos="fade-right">
                <a href="{{ route('student.complaints.index') }}" class="text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center">
                    &larr; Kembali ke Daftar
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg" data-aos="fade-up">
                <div class="p-6 text-gray-900">
                    
                    <form action="{{ route('student.complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="category_id" :value="__('Kategori Masalah')" />
                            <select name="category_id" id="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="title" :value="__('Judul Keluhan')" />
                            <x-text-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" placeholder="Contoh: AC di Ruang 301 Mati" required />
                            <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="description" :value="__('Deskripsi Detail')" />
                            <textarea name="description" id="description" rows="5" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Jelaskan masalah secara rinci..." required>{{ old('description') }}</textarea>
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="evidence_file" :value="__('Bukti Foto/Dokumen (Opsional)')" />
                            <input type="file" name="evidence_file" id="evidence_file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <p class="mt-1 text-sm text-gray-500">Maksimal 2MB (JPG, PNG, PDF, DOC).</p>
                            <x-input-error :messages="$errors->get('evidence_file')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4 bg-indigo-600 hover:bg-indigo-700">
                                {{ __('Kirim Keluhan') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>