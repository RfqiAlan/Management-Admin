<x-student-layout title="Buat Keluhan Baru">
    <!-- Page Header -->
    <div class="mb-8" data-aos="fade-down">
        <a href="{{ route('student.complaints.index') }}" 
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium mb-4 group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Dashboard</span>
        </a>
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Buat Keluhan Baru</h1>
        <p class="text-gray-500">Sampaikan keluhan kamu dengan lengkap agar dapat diproses dengan cepat.</p>
    </div>

    <!-- Form Card -->
    <div class="glass-card p-8" data-aos="fade-up">
        <form action="{{ route('student.complaints.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-folder mr-2 text-indigo-500"></i>Kategori Masalah
                </label>
                <div class="relative">
                    <select name="category_id" id="category_id" 
                            class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all appearance-none bg-white">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none">
                        <i class="fas fa-chevron-down text-gray-400"></i>
                    </div>
                </div>
                @error('category_id')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-heading mr-2 text-indigo-500"></i>Judul Keluhan
                </label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       placeholder="Contoh: AC di Ruang 301 Tidak Berfungsi"
                       class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                       required>
                @error('title')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-align-left mr-2 text-indigo-500"></i>Deskripsi Detail
                </label>
                <textarea name="description" id="description" rows="5"
                          placeholder="Jelaskan masalah secara rinci, seperti lokasi, waktu kejadian, dampak yang dirasakan, dll..."
                          class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all resize-none"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- File Upload -->
            <div>
                <label for="evidence_file" class="block text-sm font-semibold text-gray-700 mb-2">
                    <i class="fas fa-paperclip mr-2 text-indigo-500"></i>Bukti Foto/Dokumen (Opsional)
                </label>
                <div class="relative">
                    <input type="file" name="evidence_file" id="evidence_file"
                           accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                           class="hidden"
                           onchange="updateFileName(this)">
                    <label for="evidence_file" 
                           class="flex items-center justify-center gap-4 w-full px-6 py-8 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-indigo-500 hover:bg-indigo-50/50 transition-all group">
                        <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i class="fas fa-cloud-upload-alt text-2xl text-indigo-500"></i>
                        </div>
                        <div class="text-center">
                            <p class="font-medium text-gray-700" id="file-name">Klik untuk upload file</p>
                            <p class="text-sm text-gray-500">JPG, PNG, PDF, DOC (Maks. 2MB)</p>
                        </div>
                    </label>
                </div>
                @error('evidence_file')
                    <p class="mt-2 text-sm text-red-500 flex items-center gap-1">
                        <i class="fas fa-exclamation-circle"></i>{{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Tips Box -->
            <div class="p-4 rounded-xl bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-100">
                <h4 class="font-semibold text-indigo-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-lightbulb text-yellow-500"></i>
                    Tips Membuat Keluhan
                </h4>
                <ul class="text-sm text-indigo-700 space-y-1">
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        <span>Jelaskan masalah dengan jelas dan spesifik</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        <span>Sertakan lokasi dan waktu kejadian jika relevan</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
                        <span>Upload bukti foto/dokumen untuk mempercepat proses</span>
                    </li>
                </ul>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit" 
                        class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-4 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02] focus:ring-4 focus:ring-indigo-200">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirim Keluhan</span>
                </button>
                <a href="{{ route('student.complaints.index') }}" 
                   class="inline-flex items-center justify-center gap-2 px-6 py-4 bg-gray-100 text-gray-600 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>

    <script>
        function updateFileName(input) {
            const fileName = document.getElementById('file-name');
            if (input.files.length > 0) {
                fileName.textContent = input.files[0].name;
                fileName.classList.add('text-indigo-600');
            } else {
                fileName.textContent = 'Klik untuk upload file';
                fileName.classList.remove('text-indigo-600');
            }
        }
    </script>
</x-student-layout>
