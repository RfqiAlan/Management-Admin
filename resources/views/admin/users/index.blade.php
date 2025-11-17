<x-app-layout title="Mahasiswa">
    <div class="container py-4">
        <h1 class="h5 mb-3">Daftar Mahasiswa</h1>

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
                            <th>Email</th>
                            <th>No. WA</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($students as $s)
                        <tr>
                            <td>{{ $loop->iteration + ($students->currentPage()-1)*$students->perPage() }}</td>
                            <td>{{ $s->name }}</td>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->phone ?? '-' }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $s) }}"
                                   class="btn btn-link btn-sm">
                                    Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center small py-3">Belum ada mahasiswa.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $students->links() }}
        </div>
    </div>
</x-app-layout>
