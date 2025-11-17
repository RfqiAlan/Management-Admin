<x-app-layout :title="'Edit Mahasiswa - '.$user->name">
    <div class="container py-4">
        <div class="mb-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-link btn-sm p-0">
                &laquo; Kembali
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <h1 class="h5 mb-3">Edit Data Mahasiswa</h1>

                @if(session('success'))
                    <div class="alert alert-success small">{{ session('success') }}</div>
                @endif

                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="small">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label small">Nama</label>
                        <input type="text" name="name"
                               value="{{ old('name', $user->name) }}"
                               class="form-control form-control-sm @error('name') is-invalid @enderror" required>
                        @error('name')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $user->email) }}"
                               class="form-control form-control-sm @error('email') is-invalid @enderror" required>
                        @error('email')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label small">No. WA</label>
                        <input type="text" name="phone"
                               value="{{ old('phone', $user->phone) }}"
                               class="form-control form-control-sm @error('phone') is-invalid @enderror">
                        @error('phone')
                        <div class="invalid-feedback small">{{ $message }}</div>
                        @enderror
                        <div class="form-text small">
                            Gunakan format Indonesia, misal: 08xxxx (akan otomatis diubah ke 628xxx).
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm" type="submit">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
