<x-app-layout title="Tambah Kategori">
    <div class="container py-4">
        <div class="mb-3">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-link btn-sm p-0">
                &laquo; Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h1 class="h5 mb-3">Tambah Kategori Keluhan</h1>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="small">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label small">Nama Kategori</label>
                        <input type="text" name="name"
                               class="form-control form-control-sm @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Deskripsi (Opsional)</label>
                        <textarea name="description" rows="3"
                                  class="form-control form-control-sm @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm" type="submit">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
