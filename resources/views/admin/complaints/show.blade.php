<x-app-layout :title="$complaint->title">
    <div class="container py-4">
        <div class="mb-3">
            <a href="{{ route('admin.complaints.index') }}" class="btn btn-link btn-sm p-0">
                &laquo; Kembali
            </a>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body">
                        <h1 class="h5 mb-1">{{ $complaint->title }}</h1>
                        <p class="small text-muted mb-2">
                            Mahasiswa: <strong>{{ $complaint->user->name }}</strong><br>
                            Email: {{ $complaint->user->email }}<br>
                            No. WA: {{ $complaint->user->phone ?? '-' }}<br>
                            Kategori: <strong>{{ $complaint->category->name ?? '-' }}</strong><br>
                            Status:
                            <span class="badge text-bg-secondary text-capitalize">{{ $complaint->status }}</span><br>
                            Tanggal dibuat: {{ $complaint->created_at->format('d/m/Y H:i') }}
                        </p>

                        <p class="mb-0">
                            {!! nl2br(e($complaint->description)) !!}
                        </p>

                        @if($complaint->evidence_file)
                            <hr>
                            <p class="small mb-1 fw-semibold">Bukti Keluhan</p>
                            <a href="{{ asset('storage/' . $complaint->evidence_file) }}" target="_blank" class="small">
                                Lihat Lampiran
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Rating dari mahasiswa (jika ada) --}}
                @if($complaint->rating)
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body">
                            <h2 class="h6 mb-2">Feedback Mahasiswa</h2>
                            <p class="small mb-1">
                                Rating: <strong>{{ $complaint->rating }}/5</strong>
                            </p>
                            <p class="small mb-0">
                                Komentar: {!! nl2br(e($complaint->feedback ?? '-')) !!}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Riwayat Tindak Lanjut</h2>
                        @forelse($complaint->responses as $resp)
                            <div class="mb-3 pb-2 border-bottom small">
                                <div class="fw-semibold">
                                    {{ $resp->admin->name ?? 'Admin' }}
                                </div>
                                <div class="text-muted">
                                    {{ $resp->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="mt-1">
                                    {!! nl2br(e($resp->note)) !!}
                                </div>
                                @if($resp->attachment)
                                    <div class="mt-1">
                                        <a href="{{ asset('storage/'.$resp->attachment) }}" target="_blank">
                                            Lihat Lampiran
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="small text-muted mb-0">Belum ada tindak lanjut.</p>
                        @endforelse
                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">
                        <h2 class="h6 mb-3">Update Status & Tambah Catatan</h2>

                        @if(session('success'))
                            <div class="alert alert-success small">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger small">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('admin.complaints.respond', $complaint) }}"
                              method="POST" enctype="multipart/form-data" class="small">
                            @csrf

                            <div class="mb-2">
                                <label class="form-label small">Status</label>
                                <select name="status"
                                        class="form-select form-select-sm @error('status') is-invalid @enderror"
                                        required>
                                    @foreach(['pending','diproses','selesai','ditolak'] as $st)
                                        <option value="{{ $st }}" @selected(old('status', $complaint->status) == $st)>
                                            {{ ucfirst($st) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label class="form-label small">Catatan Tindak Lanjut</label>
                                <textarea name="note" rows="3"
                                          class="form-control form-control-sm @error('note') is-invalid @enderror"
                                          required>{{ old('note') }}</textarea>
                                @error('note')
                                <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2">
                                <label class="form-label small">Lampiran (Opsional)</label>
                                <input type="file" name="attachment"
                                       class="form-control form-control-sm @error('attachment') is-invalid @enderror">
                                @error('attachment')
                                <div class="invalid-feedback small">{{ $message }}</div>
                                @enderror
                                <div class="form-text small">jpg, jpeg, png, pdf, doc, docx (maks 2MB).</div>
                            </div>

                            <div class="d-flex justify-content-end mt-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    Simpan & Kirim WA
                                </button>
                            </div>
                        </form>

                        <div class="mt-2 small text-muted">
                            *Mahasiswa akan menerima notifikasi WhatsApp ketika status diperbarui.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
