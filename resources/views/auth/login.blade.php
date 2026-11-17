@extends('layouts.guest')
@section('title', 'Login - Sistem Tiket Wisata Pa Ali')

@section('content')
<div class="card auth-card p-4 bg-white">
    <div class="text-center mb-4">
        <div class="display-5 text-primary mb-2"><i class="bi bi-ticket-perforated-fill"></i></div>
        <h4 class="fw-bold text-dark mb-1">Wisata Pa Ali Online</h4>
        <p class="text-muted small">Silakan login untuk memesan tiket atau mengelola sistem</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success small">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger small">{{ $errors->first() }}</div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold">Alamat Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', 'admin@paali.com') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label class="form-label fw-semibold">Password</label>
            <input type="password" name="password" class="form-control" value="password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember">
            <label class="form-check-label small" for="remember">Ingat sesi login saya</label>
        </div>
        <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
            <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
        </button>
    </form>

    <div class="mt-3 p-3 bg-light rounded small">
        <div class="fw-bold mb-1 text-dark">Akun Demo (Password: <code>password</code>):</div>
        <div><span class="badge bg-primary">Admin</span> <code>admin@paali.com</code></div>
        <div class="mt-1"><span class="badge bg-success">Pengunjung</span> <code>budi@gmail.com</code></div>
    </div>

    <div class="text-center mt-3 small">
        Belum punya akun pengunjung? <a href="{{ route('register') }}" class="fw-bold text-decoration-none">Daftar Akun Baru</a>
    </div>
</div>
@endsection
