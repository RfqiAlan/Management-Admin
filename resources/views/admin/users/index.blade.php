<x-admin-layout title="Kelola Pengguna" header="Kelola Pengguna">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6" data-aos="fade-down">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Pengguna</h1>
            <p class="text-gray-500">Kelola akun mahasiswa dan administrator</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl">
            <i class="fas fa-users"></i>
            <span class="font-semibold">{{ $users->total() }} Pengguna</span>
        </div>
    </div>

    <!-- Users Table -->
    <div class="glass-card rounded-2xl overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Telepon</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Terdaftar</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 text-gray-500">
                                {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $user->role === 'admin' ? 'from-indigo-400 to-purple-500' : 'from-emerald-400 to-teal-500' }} flex items-center justify-center text-white font-semibold shadow-lg">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-700">
                                        <i class="fas fa-shield-alt"></i>
                                        Administrator
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                        <i class="fas fa-user-graduate"></i>
                                        Mahasiswa
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                @if($user->phone)
                                    <span class="flex items-center gap-1">
                                        <i class="fas fa-phone text-gray-400 text-xs"></i>
                                        {{ $user->phone }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-800">{{ $user->created_at->format('d M Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" 
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 text-indigo-600 rounded-lg text-sm font-medium hover:bg-indigo-100 transition-colors">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    @if(auth()->id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1 px-3 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-sm font-medium hover:bg-rose-100 transition-colors">
                                                <i class="fas fa-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                        <i class="fas fa-users text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Tidak ada data pengguna</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                {{ $users->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>
