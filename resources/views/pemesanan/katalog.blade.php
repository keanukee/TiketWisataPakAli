@extends('layouts.app')
@section('title', 'Katalog Destinasi Wisata Pa Ali')
@section('page_title', 'Katalog & Pencarian Tiket Wisata')

@section('content')
<div class="card card-mazer p-3 mb-4">
    <form action="{{ route('katalog') }}" method="GET" class="row g-2 align-items-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control" placeholder="Cari nama wisata atau lokasi..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="kategori_id" class="form-select">
                <option value="">Semua Kategori Wisata</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="sort" class="form-select">
                <option value="">Urutkan: Terbaru</option>
                <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>Harga Terendah</option>
                <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>Harga Tertinggi</option>
            </select>
        </div>
        <div class="col-md-2 d-grid">
            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-search me-1"></i> Cari</button>
        </div>
    </form>
</div>

<div class="row g-4">
    @forelse($destinasi as $d)
        <div class="col-md-4">
            <div class="card card-mazer h-100">
                <img src="{{ $d->gambar_url }}" class="destinasi-img" alt="{{ $d->nama_wisata }}">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge bg-light text-primary">{{ $d->kategori->nama_kategori }}</span>
                        <small class="text-muted">Kuota: {{ $d->kuota_harian }}/hari</small>
                    </div>
                    <h5 class="fw-bold">{{ $d->nama_wisata }}</h5>
                    <p class="small text-muted mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $d->lokasi }}</p>
                    <p class="small text-secondary">{{ Str::limit($d->deskripsi, 110) }}</p>
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center">
                        <div>
                            <small class="text-muted d-block">Harga Tiket</small>
                            <span class="fs-5 fw-bold text-primary">Rp {{ number_format($d->harga_tiket, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('pemesanan.create', ['destinasi_id' => $d->id]) }}" class="btn btn-primary fw-bold">
                            <i class="bi bi-ticket-perforated me-1"></i> Pesan Tiket
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card card-mazer p-5 text-center text-muted">
                Destinasi wisata yang Anda cari tidak ditemukan.
            </div>
        </div>
    @endforelse
</div>
@endsection
