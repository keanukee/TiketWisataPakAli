@extends('layouts.app')
@section('title', 'Tambah Destinasi Wisata')
@section('page_title', 'Tambah Destinasi Wisata Baru')

@section('content')
<div class="card card-mazer p-4">
    <form action="{{ route('destinasi.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Wisata</label>
                <input type="text" name="kode_wisata" class="form-control" value="{{ old('kode_wisata', $kodeOtomatis) }}" required>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Destinasi / Wahana Wisata</label>
                <input type="text" name="nama_wisata" class="form-control" value="{{ old('nama_wisata') }}" placeholder="Contoh: Kolam Renang Alami Pa Ali" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kategori Wisata</label>
                <select name="kategori_id" class="form-select" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Harga Tiket (Rp)</label>
                <input type="number" name="harga_tiket" class="form-control" value="{{ old('harga_tiket', 25000) }}" min="0" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Batas Kuota Pengunjung / Hari</label>
                <input type="number" name="kuota_harian" class="form-control" value="{{ old('kuota_harian', 100) }}" min="1" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Lokasi / Zona Area</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" placeholder="Contoh: Zona Barat, Wisata Pa Ali" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">URL Gambar Cover (Opsional)</label>
                <input type="url" name="gambar_url" class="form-control" value="{{ old('gambar_url') }}" placeholder="https://...">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi & Fasilitas</label>
                <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold">Simpan Destinasi</button>
            <a href="{{ route('destinasi.index') }}" class="btn btn-light">Batal</a>
        </div>
    </form>
</div>
@endsection
