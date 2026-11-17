@extends('layouts.app')
@section('title', 'Rekap Laporan Penjualan - Wisata Pa Ali')
@section('page_title', 'Rekap Laporan Penjualan Tiket')

@section('content')
<div class="card card-mazer p-4 mb-4 no-print">
    <form action="{{ route('laporan.index') }}" method="GET" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-semibold">Dari Tanggal Kunjungan</label>
            <input type="date" name="dari" class="form-control" value="{{ $dari }}">
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold">Sampai Tanggal</label>
            <input type="date" name="sampai" class="form-control" value="{{ $sampai }}">
        </div>
        <div class="col-md-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-filter me-1"></i> Tampilkan</button>
            <button type="button" onclick="window.print()" class="btn btn-outline-dark fw-bold"><i class="bi bi-printer me-1"></i> Cetak Laporan</button>
        </div>
    </form>
</div>

<div class="card card-mazer p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="fw-bold mb-0">Laporan Penjualan Tiket Wisata Pa Ali</h5>
            <small class="text-muted">Periode: {{ \Carbon\Carbon::parse($dari)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($sampai)->format('d M Y') }}</small>
        </div>
        <div class="text-end">
            <div class="small text-muted">Total Pemasukan Lunas</div>
            <h4 class="fw-bold text-success mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }} ({{ $totalTiket }} Tiket)</h4>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Kode Booking</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Pengunjung</th>
                    <th>Destinasi Wisata</th>
                    <th>Metode</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksi as $i => $t)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td class="fw-bold">{{ $t->kode_booking }}</td>
                        <td>{{ $t->tanggal_kunjungan->format('d/m/Y') }}</td>
                        <td>{{ $t->user->name }}</td>
                        <td>{{ $t->destinasi->nama_wisata }}</td>
                        <td>{{ $t->metode_pembayaran }}</td>
                        <td>{{ $t->jumlah_tiket }}</td>
                        <td class="fw-bold">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">Tidak ada transaksi lunas pada rentang tanggal ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
