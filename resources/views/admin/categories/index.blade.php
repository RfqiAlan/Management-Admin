<x-admin-layout title="Kategori Keluhan" header="Kategori Keluhan">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6" data-aos="fade-down">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Master Kategori</h1>
            <p class="text-gray-500">Kelola kategori untuk klasifikasi keluhan</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" 
           class="inline-flex items-center gap-2 px-5 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all hover:scale-105">
            <i class="fas fa-plus-circle"></i>
            <span>Tambah Kategori</span>
        </a>
    </div>

    <!-- Categories Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" data-aos="fade-up">
        @forelse($categories as $cat)
            <div class="glass-card rounded-2xl p-6 group hover:shadow-2xl transition-all duration-300">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas fa-folder-open text-white text-xl"></i>
                    </div>
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-xs font-semibold">
                        #{{ $loop->iteration }}
                    </span>
                </div>
                
                <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $cat->name }}</h3>
                <p class="text-sm text-gray-500 mb-4 line-clamp-2">{{ $cat->description ?? 'Tidak ada deskripsi' }}</p>
                
                <div class="flex items-center gap-2 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.categories.edit', $cat) }}" 
                       class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-sm font-medium hover:bg-indigo-100 transition-colors">
                        <i class="fas fa-edit"></i>
                        Edit
                    </a>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" class="flex-1"
                          onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="w-full inline-flex items-center justify-center gap-2 px-4 py-2 bg-rose-50 text-rose-600 rounded-xl text-sm font-medium hover:bg-rose-100 transition-colors">
                            <i class="fas fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="glass-card rounded-2xl p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 flex items-center justify-center">
                        <i class="fas fa-folder-plus text-4xl text-indigo-400"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Kategori</h3>
                    <p class="text-gray-500 mb-6">Mulai dengan menambahkan kategori pertama untuk keluhan</p>
                    <a href="{{ route('admin.categories.create') }}" 
                       class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-plus-circle"></i>
                        <span>Tambah Kategori</span>
                    </a>
                </div>
            </div>
        @endforelse
    </div>
</x-admin-layout>
