@extends('layouts.app')
@section('title', 'Edit Destinasi Wisata')
@section('page_title', 'Edit Data Destinasi Wisata')

@section('content')
<div class="card card-mazer p-4">
    <form action="{{ route('destinasi.update', $destinasi->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kode Wisata</label>
                <input type="text" name="kode_wisata" class="form-control" value="{{ old('kode_wisata', $destinasi->kode_wisata) }}" required>
            </div>
            <div class="col-md-8">
                <label class="form-label fw-semibold">Nama Destinasi Wisata</label>
                <input type="text" name="nama_wisata" class="form-control" value="{{ old('nama_wisata', $destinasi->nama_wisata) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kategori Wisata</label>
                <select name="kategori_id" class="form-select" required>
                    @foreach($kategori as $k)
                        <option value="{{ $k->id }}" {{ $destinasi->kategori_id == $k->id ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Harga Tiket (Rp)</label>
                <input type="number" name="harga_tiket" class="form-control" value="{{ old('harga_tiket', $destinasi->harga_tiket) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Kuota Harian</label>
                <input type="number" name="kuota_harian" class="form-control" value="{{ old('kuota_harian', $destinasi->kuota_harian) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Lokasi</label>
                <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $destinasi->lokasi) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">URL Gambar</label>
                <input type="url" name="gambar_url" class="form-control" value="{{ old('gambar_url', $destinasi->gambar_url) }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="aktif" {{ $destinasi->status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ $destinasi->status === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $destinasi->deskripsi) }}</textarea>
            </div>
        </div>
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary fw-bold">Update Destinasi</button>
            <a href="{{ route('destinasi.index') }}" class="btn btn-light">Kembali</a>
        </div>
    </form>
</div>
@endsection
