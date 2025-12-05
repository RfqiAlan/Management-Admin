<x-admin-layout title="Edit Kategori" header="Edit Kategori">
    <!-- Back Button -->
    <div class="mb-6" data-aos="fade-right">
        <a href="{{ route('admin.categories.index') }}" 
           class="inline-flex items-center gap-2 text-indigo-600 hover:text-indigo-800 font-medium group">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            <span>Kembali ke Daftar Kategori</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl" data-aos="fade-up">
        <div class="glass-card rounded-2xl p-8">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center shadow-lg">
                    <i class="fas fa-edit text-white text-xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Edit Kategori</h2>
                    <p class="text-sm text-gray-500">Perbarui informasi kategori</p>
                </div>
            </div>

            <form action="{{ route('admin.categories.update', $category) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-tag mr-1 text-indigo-500"></i>Nama Kategori
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                           placeholder="Contoh: Fasilitas, Akademik, dll"
                           class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all"
                           required>
                    @error('name')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-align-left mr-1 text-indigo-500"></i>Deskripsi (Opsional)
                    </label>
                    <textarea name="description" id="description" rows="4"
                              placeholder="Jelaskan tentang kategori ini..."
                              class="block w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 transition-all resize-none">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 pt-4">
                    <button type="submit" 
                            class="flex-1 px-6 py-4 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-[1.02]">
                        <i class="fas fa-save mr-2"></i>
                        Update Kategori
                    </button>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="px-6 py-4 bg-gray-100 text-gray-600 rounded-xl font-semibold hover:bg-gray-200 transition-all">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
