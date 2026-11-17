@extends('layouts.app')
@section('title', 'Edit Pemesanan Tiket')
@section('page_title', 'Edit Data Pemesanan: ' . $pemesanan->kode_booking)

@section('content')
<div class="card card-mazer p-4">
    <form action="{{ route('pemesanan.update', $pemesanan->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Destinasi Wisata</label>
                <select name="destinasi_id" class="form-select" required>
                    @foreach($destinasiList as $item)
                        <option value="{{ $item->id }}" {{ $pemesanan->destinasi_id == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_wisata }} (Rp {{ number_format($item->harga_tiket, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Tanggal Kunjungan</label>
                <input type="date" name="tanggal_kunjungan" class="form-control" value="{{ $pemesanan->tanggal_kunjungan->format('Y-m-d') }}" required>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Jumlah Tiket</label>
                <input type="number" name="jumlah_tiket" class="form-control" min="1" max="50" value="{{ $pemesanan->jumlah_tiket }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Metode Pembayaran</label>
                <select name="metode_pembayaran" class="form-select">
                    @foreach(['QRIS', 'Transfer VA', 'E-Wallet', 'Bayar di Loket'] as $m)
                        <option value="{{ $m }}" {{ $pemesanan->metode_pembayaran === $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>

            @if(auth()->user()->isAdmin())
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Pembayaran (Admin)</label>
                    <select name="status_pembayaran" class="form-select">
                        <option value="pending" {{ $pemesanan->status_pembayaran === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="lunas" {{ $pemesanan->status_pembayaran === 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="dibatalkan" {{ $pemesanan->status_pembayaran === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Status Check-In (Admin)</label>
                    <select name="status_checkin" class="form-select">
                        <option value="belum_checkin" {{ $pemesanan->status_checkin === 'belum_checkin' ? 'selected' : '' }}>Belum Check-in</option>
                        <option value="sudah_checkin" {{ $pemesanan->status_checkin === 'sudah_checkin' ? 'selected' : '' }}>Sudah Check-in</option>
                    </select>
                </div>
            @endif

            <div class="col-12">
                <label class="form-label fw-semibold">Catatan</label>
                <textarea name="catatan" rows="2" class="form-control">{{ $pemesanan->catatan }}</textarea>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold">Simpan Perubahan</button>
            <a href="{{ route('pemesanan.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</div>
@endsection
