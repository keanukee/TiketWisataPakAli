@extends('layouts.app')
@section('title', 'E-Ticket ' . $pemesanan->kode_booking)
@section('page_title', 'E-Ticket & QR Code Pengunjung')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-7">
        <div class="card card-mazer p-4 border-top border-5 border-primary">
            <div class="d-flex justify-content-between align-items-start border-bottom pb-3 mb-3">
                <div>
                    <span class="badge bg-primary mb-1">E-TICKET RESMI</span>
                    <h4 class="fw-bold mb-0">Wisata Pa Ali</h4>
                    <small class="text-muted">{{ $pemesanan->destinasi->lokasi }}</small>
                </div>
                <div class="text-end">
                    <div class="small text-muted">Kode Booking</div>
                    <div class="fw-bold text-primary fs-6">{{ $pemesanan->kode_booking }}</div>
                </div>
            </div>

            <div class="row align-items-center">
                <div class="col-md-7">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="text-muted">Nama Pengunjung</td>
                            <td class="fw-bold">: {{ $pemesanan->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Destinasi Wisata</td>
                            <td class="fw-bold">: {{ $pemesanan->destinasi->nama_wisata }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Tanggal Kunjungan</td>
                            <td class="fw-bold">: {{ $pemesanan->tanggal_kunjungan->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Jumlah Tiket</td>
                            <td class="fw-bold">: {{ $pemesanan->jumlah_tiket }} Orang</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Total Bayar</td>
                            <td class="fw-bold text-success">: Rp {{ number_format($pemesanan->total_harga, 0, ',', '.') }} ({{ $pemesanan->metode_pembayaran }})</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status Tiket</td>
                            <td>:
                                @if($pemesanan->status_pembayaran === 'lunas')
                                    <span class="badge bg-success">LUNAS / AKTIF</span>
                                @else
                                    <span class="badge bg-warning text-dark">BELUM LUNAS ({{ strtoupper($pemesanan->status_pembayaran) }})</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-5 text-center">
                    <div id="qrcode" class="d-inline-block p-2 bg-white border rounded"></div>
                    <div class="small text-muted mt-2">Tunjukkan QR Code ini kepada petugas loket saat masuk</div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-between no-print">
                <a href="{{ route('pemesanan.index') }}" class="btn btn-light">Kembali</a>
                <div class="d-flex gap-2">
                    @if($pemesanan->status_pembayaran === 'pending')
                        <form action="{{ route('pemesanan.bayar', $pemesanan->id) }}" method="POST">
                            @csrf
                            <button class="btn btn-success fw-bold">Konfirmasi Bayar Sekarang</button>
                        </form>
                    @endif
                    <button onclick="window.print()" class="btn btn-primary fw-bold">
                        <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan PDF E-Ticket
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script>
    new QRCode(document.getElementById("qrcode"), {
        text: "{{ $pemesanan->kode_booking }}",
        width: 150,
        height: 150,
        colorDark : "#25396f",
        colorLight : "#ffffff"
    });
</script>
@endpush
