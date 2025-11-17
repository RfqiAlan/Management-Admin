<x-app-layout title="Kelola Keluhan">
    <div class="container py-4">
        <h1 class="h5 mb-3">Kelola Keluhan Mahasiswa</h1>

        <form class="card border-0 shadow-sm rounded-4 mb-3 p-3">
            <div class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua</option>
                        @foreach(['pending','diproses','selesai','ditolak'] as $st)
                            <option value="{{ $st }}" @selected(request('status') === $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                           class="form-control form-control-sm">
                </div>

                <div class="col-md-2">
                    <label class="form-label small">Sampai Tanggal</label>
                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                           class="form-control form-control-sm">
                </div>

                <div class="col-md-3">
                    <label class="form-label small">Nama / Email Mahasiswa</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                           class="form-control form-control-sm" placeholder="Cari mahasiswa...">
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary btn-sm mt-3 mt-md-0" type="submit">
                        Filter
                    </button>
                    <a href="{{ route('admin.complaints.index') }}" class="btn btn-light btn-sm mt-3 mt-md-0">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Mahasiswa</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Rating</th>
                            <th>Tanggal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($complaints as $c)
                        <tr>
                            <td>{{ $loop->iteration + ($complaints->currentPage()-1)*$complaints->perPage() }}</td>
                            <td>{{ $c->title }}</td>
                            <td>{{ $c->user->name }}<br><span class="small text-muted">{{ $c->user->email }}</span></td>
                            <td>{{ $c->category->name ?? '-' }}</td>
                            <td>
                                <span class="badge text-bg-secondary text-capitalize">{{ $c->status }}</span>
                            </td>
                            <td>{{ $c->rating ?? '-' }}</td>
                            <td>{{ $c->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.complaints.show', $c) }}"
                                   class="btn btn-link btn-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center small py-3">
                                Tidak ada keluhan.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3">
            {{ $complaints->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
