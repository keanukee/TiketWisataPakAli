@extends('layouts.app')
@section('title', 'Validasi E-Ticket QR - Wisata Pa Ali')
@section('page_title', 'Modul Validasi Tiket Masuk (Petugas Loket)')

@section('content')
<div class="row g-4">
    <div class="col-md-5">
        <div class="card card-mazer p-4">
            <h6 class="fw-bold mb-2"><i class="bi bi-qr-code-scan text-primary me-1"></i> Cek Kode Booking / Scan QR</h6>
            <p class="small text-muted">Masukkan atau scan kode booking pada E-Ticket pengunjung untuk memverifikasi keaslian dan status check-in.</p>
            <form action="{{ route('validasi.form') }}" method="GET">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Kode Booking E-Ticket</label>
                    <input type="text" name="kode_booking" class="form-control form-control-lg" placeholder="Contoh: TKT-PAALI-2026001" value="{{ request('kode_booking') }}" required autofocus>
                </div>
                <button type="submit" class="btn btn-primary w-100 fw-bold">
                    <i class="bi bi-search me-1"></i> Periksa Tiket
                </button>
            </form>
        </div>
    </div>

    <div class="col-md-7">
        @if(request()->filled('kode_booking'))
            @if($hasilTiket)
                <div class="card card-mazer p-4 border-start border-5 {{ $hasilTiket->status_pembayaran === 'lunas' ? 'border-success' : 'border-danger' }}">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold mb-0">{{ $hasilTiket->kode_booking }}</h5>
                        <span class="badge {{ $hasilTiket->status_pembayaran === 'lunas' ? 'bg-success' : 'bg-danger' }}">
                            {{ strtoupper($hasilTiket->status_pembayaran) }}
                        </span>
                    </div>
                    <p class="mb-1"><strong>Pengunjung:</strong> {{ $hasilTiket->user->name }} ({{ $hasilTiket->user->no_hp }})</p>
                    <p class="mb-1"><strong>Destinasi:</strong> {{ $hasilTiket->destinasi->nama_wisata }}</p>
                    <p class="mb-1"><strong>Tanggal Kunjungan:</strong> {{ $hasilTiket->tanggal_kunjungan->format('d F Y') }}</p>
                    <p class="mb-3"><strong>Jumlah Pengunjung:</strong> {{ $hasilTiket->jumlah_tiket }} Orang</p>

                    @if($hasilTiket->status_checkin === 'sudah_checkin')
                        <div class="alert alert-warning fw-bold mb-0">
                            <i class="bi bi-exclamation-circle-fill me-1"></i> TIKET INI SUDAH CHECK-IN SEBELUMNYA!
                        </div>
                    @elseif($hasilTiket->status_pembayaran === 'lunas')
                        <form action="{{ route('validasi.checkin', $hasilTiket->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100 fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i> VALIDASI & IZINKAN MASUK (CHECK-IN)
                            </button>
                        </form>
                    @else
                        <div class="alert alert-danger mb-0">
                            Tiket belum dibayar lunas. Silakan selesaikan pembayaran terlebih dahulu.
                        </div>
                    @endif
                </div>
            @else
                <div class="card card-mazer p-4 text-center text-danger">
                    <i class="bi bi-x-circle display-4 mb-2"></i>
                    <h6 class="fw-bold">Kode Booking Tidak Ditemukan!</h6>
                    <p class="small text-muted mb-0">Pastikan kode E-Ticket yang dimasukkan sudah benar.</p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
