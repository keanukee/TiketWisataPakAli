@extends('layouts.app')
@section('title', 'CRUD Kategori Wisata - Wisata Pa Ali')
@section('page_title', 'Manajemen Kategori Wisata')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card card-mazer p-4">
            <h6 class="fw-bold mb-3"><i class="bi bi-plus-circle me-1 text-primary"></i> Tambah Kategori Baru</h6>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label fw-semibold">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Wisata Air" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Class Bootstrap Icon</label>
                    <input type="text" name="ikon" class="form-control" value="bi-compass" placeholder="Contoh: bi-tree-fill">
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" rows="3" class="form-control" placeholder="Keterangan singkat kategori..."></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">Simpan Kategori</button>
            </form>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card card-mazer p-4">
            <h6 class="fw-bold mb-3">Daftar Kategori Wisata Pa Ali</h6>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Deskripsi</th>
                            <th>Jml Wisata</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $k)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-bold"><i class="bi {{ $k->ikon }} text-primary me-1"></i> {{ $k->nama_kategori }}</td>
                                <td class="small text-muted">{{ $k->deskripsi }}</td>
                                <td><span class="badge bg-info text-dark">{{ $k->destinasi_count }} Destinasi</span></td>
                                <td>
                                    <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editKat{{ $k->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('kategori.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="editKat{{ $k->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form action="{{ route('kategori.update', $k->id) }}" method="POST" class="modal-content">
                                        @csrf @method('PUT')
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-bold">Edit Kategori Wisata</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama Kategori</label>
                                                <input type="text" name="nama_kategori" class="form-control" value="{{ $k->nama_kategori }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Ikon</label>
                                                <input type="text" name="ikon" class="form-control" value="{{ $k->ikon }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Deskripsi</label>
                                                <textarea name="deskripsi" rows="3" class="form-control">{{ $k->deskripsi }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
