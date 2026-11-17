@extends('layouts.app')
@section('title', 'Kelola Destinasi Wisata - Wisata Pa Ali')
@section('page_title', 'Kelola Destinasi Wisata & Kuota Tiket')

@section('content')
<div class="card card-mazer p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <form action="{{ route('destinasi.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari wisata / kode..." value="{{ request('search') }}">
            <select name="kategori_id" class="form-select form-select-sm">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
            <button class="btn btn-sm btn-outline-primary">Filter</button>
        </form>
        <a href="{{ route('destinasi.create') }}" class="btn btn-primary btn-sm fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Tambah Destinasi Wisata
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Destinasi Wisata</th>
                    <th>Kategori</th>
                    <th>Harga Tiket</th>
                    <th>Kuota Harian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($destinasi as $d)
                    <tr>
                        <td class="fw-bold">{{ $d->kode_wisata }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $d->gambar_url }}" width="55" height="40" class="rounded object-fit-cover" alt="">
                                <div>
                                    <div class="fw-bold">{{ $d->nama_wisata }}</div>
                                    <small class="text-muted">{{ $d->lokasi }}</small>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-primary">{{ $d->kategori->nama_kategori }}</span></td>
                        <td class="fw-bold text-success">Rp {{ number_format($d->harga_tiket, 0, ',', '.') }}</td>
                        <td>{{ $d->kuota_harian }} Orang/Hari</td>
                        <td>
                            <span class="badge {{ $d->status === 'aktif' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($d->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('destinasi.edit', $d->id) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                            <form action="{{ route('destinasi.destroy', $d->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus destinasi ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Data destinasi wisata belum tersedia.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $destinasi->links() }}
</div>
@endsection
