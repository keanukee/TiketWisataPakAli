<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DestinasiWisataController;
use App\Http\Controllers\KategoriWisataController;
use App\Http\Controllers\PemesananTiketController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/katalog-wisata', [PemesananTiketController::class, 'katalog'])->name('katalog');
    Route::resource('pemesanan', PemesananTiketController::class)->except(['show']);
    Route::post('/pemesanan/{pemesanan}/bayar', [PemesananTiketController::class, 'konfirmasiBayar'])->name('pemesanan.bayar');
    Route::get('/pemesanan/{pemesanan}/eticket', [PemesananTiketController::class, 'eticket'])->name('pemesanan.eticket');

    Route::middleware('role:admin')->group(function () {
        Route::resource('kategori', KategoriWisataController::class)->except(['create', 'show', 'edit']);
        Route::resource('destinasi', DestinasiWisataController::class)->except(['show']);
        Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);

        Route::get('/validasi-tiket', [PemesananTiketController::class, 'validasiForm'])->name('validasi.form');
        Route::post('/validasi-tiket/{pemesanan}/checkin', [PemesananTiketController::class, 'validasiCheckin'])->name('validasi.checkin');
        Route::get('/laporan-penjualan', [PemesananTiketController::class, 'laporan'])->name('laporan.index');
    });
});
