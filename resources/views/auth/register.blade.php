@extends('layouts.guest')
@section('title', 'Registrasi Pengunjung - Wisata Pa Ali')

@section('content')
<div class="card auth-card p-4 bg-white">
    <div class="text-center mb-3">
        <h4 class="fw-bold text-primary mb-1">Daftar Akun Pengunjung</h4>
        <p class="text-muted small">Buat akun untuk membeli tiket Wisata Pa Ali secara online</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger small">
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Contoh: Andi Wijaya" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="andi@email.com" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Nomor HP / WhatsApp</label>
            <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="0812xxxxxxxx" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Daftar & Masuk</button>
    </form>

    <div class="text-center mt-3 small">
        Sudah punya akun? <a href="{{ route('login') }}" class="fw-bold text-decoration-none">Login di sini</a>
    </div>
</div>
@endsection
