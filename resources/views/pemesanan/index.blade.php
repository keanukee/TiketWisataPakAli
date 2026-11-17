@extends('layouts.app')
@section('title', 'Daftar Pemesanan Tiket - Wisata Pa Ali')
@section('page_title', auth()->user()->isAdmin() ? 'Kelola Semua Pemesanan Tiket' : 'Riwayat Pemesanan & E-Ticket Saya')

@section('content')
<div class="card card-mazer p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
        <form action="{{ route('pemesanan.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Kode Booking..." value="{{ request('search') }}">
            <select name="status_pembayaran" class="form-select form-select-sm">
                <option value="">Semua Status</option>
                <option value="lunas" {{ request('status_pembayaran') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="pending" {{ request('status_pembayaran') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="dibatalkan" {{ request('status_pembayaran') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button class="btn btn-sm btn-outline-primary">Filter</button>
        </form>
        <a href="{{ route('pemesanan.create') }}" class="btn btn-primary btn-sm fw-bold">
            <i class="bi bi-plus-lg me-1"></i> Pesan Tiket Baru
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode Booking</th>
                    @if(auth()->user()->isAdmin())
                        <th>Pemesan</th>
                    @endif
                    <th>Destinasi Wisata</th>
                    <th>Tgl Kunjungan</th>
                    <th>Tiket</th>
                    <th>Total Bayar</th>
                    <th>Pembayaran</th>
                    <th>Check-In</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pemesanan as $p)
                    <tr>
                        <td class="fw-bold text-primary">{{ $p->kode_booking }}</td>
                        @if(auth()->user()->isAdmin())
                            <td>{{ $p->user->name }}<br><small class="text-muted">{{ $p->user->no_hp }}</small></td>
                        @endif
                        <td>{{ $p->destinasi->nama_wisata }}</td>
                        <td>{{ $p->tanggal_kunjungan->format('d M Y') }}</td>
                        <td>{{ $p->jumlah_tiket }}</td>
                        <td class="fw-bold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}<br><small class="text-muted">{{ $p->metode_pembayaran }}</small></td>
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
                            <span class="badge {{ $p->status_checkin === 'sudah_checkin' ? 'bg-info text-dark' : 'bg-light text-muted' }}">
                                {{ $p->status_checkin === 'sudah_checkin' ? 'Sudah Masuk' : 'Belum Check-in' }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-1 flex-wrap">
                                <a href="{{ route('pemesanan.eticket', $p->id) }}" class="btn btn-sm btn-dark" title="Lihat E-Ticket QR">
                                    <i class="bi bi-qr-code"></i>
                                </a>
                                @if($p->status_pembayaran === 'pending')
                                    <form action="{{ route('pemesanan.bayar', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button class="btn btn-sm btn-success" title="Konfirmasi Bayar Lunas"><i class="bi bi-check-lg"></i> Bayar</button>
                                    </form>
                                @endif
                                <a href="{{ route('pemesanan.edit', $p->id) }}" class="btn btn-sm btn-warning" title="Edit Pesanan">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('pemesanan.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus/membatalkan pesanan ini?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" title="Hapus Pesanan"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted">Belum ada data pemesanan tiket.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $pemesanan->links() }}
</div>
@endsection
