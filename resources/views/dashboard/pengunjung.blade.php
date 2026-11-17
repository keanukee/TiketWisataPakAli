@extends('layouts.app')
@section('title', 'Dashboard Pengunjung - Wisata Pa Ali')
@section('page_title', 'Beranda Pengunjung')

@section('content')
<div class="card card-mazer p-4 mb-4 bg-primary text-white">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h4 class="fw-bold mb-1">Halo, {{ auth()->user()->name }}!</h4>
            <p class="mb-3 opacity-75">Rencanakan liburan seru Anda bersama keluarga di Wisata Pa Ali. Pesan tiket online tanpa antre di loket!</p>
            <a href="{{ route('katalog') }}" class="btn btn-light text-primary fw-bold me-2">
                <i class="bi bi-compass me-1"></i> Jelajahi Katalog Wisata
            </a>
            <a href="{{ route('pemesanan.create') }}" class="btn btn-outline-light fw-bold">
                <i class="bi bi-cart-plus me-1"></i> Pesan Tiket Sekarang
            </a>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <div class="bg-white text-dark rounded p-3 d-inline-block">
                <small class="text-muted d-block">Total Tiket Aktif Anda</small>
                <span class="fs-4 fw-bold text-primary">{{ $totalTiketSaya }} Tiket</span>
            </div>
        </div>
    </div>
</div>

<h6 class="fw-bold mb-3">Destinasi Wisata Populer Pa Ali</h6>
<div class="row g-3 mb-4">
    @foreach($destinasiUnggulan as $d)
        <div class="col-md-3 col-sm-6">
            <div class="card card-mazer h-100">
                <img src="{{ $d->gambar_url }}" class="destinasi-img" alt="{{ $d->nama_wisata }}">
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-light text-primary mb-2 align-self-start">{{ $d->kategori->nama_kategori }}</span>
                    <h6 class="fw-bold">{{ $d->nama_wisata }}</h6>
                    <p class="small text-muted mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> {{ $d->lokasi }}</p>
                    <div class="mt-auto pt-2 border-top d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-primary">Rp {{ number_format($d->harga_tiket, 0, ',', '.') }}</span>
                        <a href="{{ route('pemesanan.create', ['destinasi_id' => $d->id]) }}" class="btn btn-sm btn-primary">Pesan</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="card card-mazer p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Riwayat Pemesanan Terakhir Saya</h6>
        <a href="{{ route('pemesanan.index') }}" class="btn btn-sm btn-outline-primary">Semua Riwayat</a>
    </div>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode Booking</th>
                    <th>Destinasi</th>
                    <th>Tgl Kunjungan</th>
                    <th>Tiket</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>E-Ticket</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananSaya as $p)
                    <tr>
                        <td class="fw-bold">{{ $p->kode_booking }}</td>
                        <td>{{ $p->destinasi->nama_wisata }}</td>
                        <td>{{ $p->tanggal_kunjungan->format('d M Y') }}</td>
                        <td>{{ $p->jumlah_tiket }}</td>
                        <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge {{ $p->status_pembayaran === 'lunas' ? 'bg-success' : ($p->status_pembayaran === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($p->status_pembayaran) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('pemesanan.eticket', $p->id) }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-qr-code"></i> Lihat Tiket
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Anda belum memiliki riwayat pemesanan tiket.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
