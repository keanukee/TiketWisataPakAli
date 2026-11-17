@extends('layouts.app')
@section('title', 'Dashboard Admin - Wisata Pa Ali')
@section('page_title', 'Dashboard Pengelola (Admin)')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-primary"><i class="bi bi-cash-coin"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Total Pendapatan</small>
                    <h5 class="fw-bold mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-success"><i class="bi bi-ticket-detailed-fill"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Tiket Terjual (Lunas)</small>
                    <h5 class="fw-bold mb-0">{{ $totalTiketTerjual }} Tiket</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-info"><i class="bi bi-map-fill"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Destinasi Wisata</small>
                    <h5 class="fw-bold mb-0">{{ $totalDestinasi }} Wahana</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6">
        <div class="card card-mazer p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="stats-icon bg-warning"><i class="bi bi-hourglass-split"></i></div>
                <div>
                    <small class="text-muted fw-semibold">Menunggu Pembayaran</small>
                    <h5 class="fw-bold mb-0">{{ $pesananPending }} Pesanan</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-mazer p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="fw-bold mb-0">Transaksi Pemesanan Tiket Terbaru</h6>
        <a href="{{ route('pemesanan.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode Booking</th>
                    <th>Pengunjung</th>
                    <th>Destinasi</th>
                    <th>Tgl Kunjungan</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pesananTerbaru as $p)
                    <tr>
                        <td class="fw-bold text-primary">{{ $p->kode_booking }}</td>
                        <td>{{ $p->user->name }}</td>
                        <td>{{ $p->destinasi->nama_wisata }}</td>
                        <td>{{ $p->tanggal_kunjungan->format('d M Y') }}</td>
                        <td>{{ $p->jumlah_tiket }} Tiket</td>
                        <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if($p->status_pembayaran === 'lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($p->status_pembayaran === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('pemesanan.eticket', $p->id) }}" class="btn btn-sm btn-outline-dark">
                                <i class="bi bi-qr-code"></i> E-Ticket
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">Belum ada transaksi pemesanan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
