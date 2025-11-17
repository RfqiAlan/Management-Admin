<x-app-layout title="Buat Keluhan">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Keluhan Baru
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-lg px-4 py-2">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-xl p-6">
                <form action="{{ route('student.complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori Keluhan
                        </label>
                        <select name="category_id"
                                class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('category_id') border-rose-400 @enderror"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Judul Keluhan
                        </label>
                        <input type="text" name="title"
                               value="{{ old('title') }}"
                               class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('title') border-rose-400 @enderror"
                               required>
                        @error('title')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Deskripsi Keluhan
                        </label>
                        <textarea name="description" rows="5"
                                  class="block w-full rounded-lg border-gray-300 text-sm focus:border-indigo-500 focus:ring-indigo-500 @error('description') border-rose-400 @enderror"
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Upload Bukti (Opsional)
                        </label>
                        <input type="file" name="evidence_file"
                               class="block w-full text-sm text-gray-700 file:mr-3 file:py-1.5 file:px-3 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 @error('evidence_file') border-rose-400 @enderror">
                        @error('evidence_file')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">
                            Format: jpg, jpeg, png, pdf, doc, docx (maks 2MB).
                        </p>
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <a href="{{ route('student.complaints.index') }}"
                           class="inline-flex items-center px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 rounded-lg bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700 shadow-sm">
                            Kirim Keluhan
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
