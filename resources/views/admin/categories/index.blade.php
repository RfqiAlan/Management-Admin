<x-app-layout title="Kategori Keluhan">
    <div class="container py-4">
        <div class="d-flex justify-content-between mb-3">
            <h1 class="h5 mb-0">Kategori Keluhan</h1>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm">
                + Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success small">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $cat->name }}</td>
                            <td class="small">{{ $cat->description ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.categories.edit', $cat) }}"
                                   class="btn btn-link btn-sm">
                                    Edit
                                </a>
                                <form action="{{ route('admin.categories.destroy', $cat) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Hapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link btn-sm text-danger">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center small py-3">Belum ada kategori.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
