# Sistem Pemesanan Tiket Wisata Pa Ali Secara Online

Projek aplikasi web berbasis **Laravel 10 + Template Admin Mazer (Bootstrap 5)** untuk manajemen pemesanan tiket wisata secara online, dilengkapi autentikasi multi-user (`Admin` dan `Pengunjung`), **4 tabel relasional dengan CRUD penuh**, generator **E-Ticket QR Code**, validasi tiket masuk loket, serta rekap laporan penjualan.

## Referensi Template GitHub
- **Mazer Bootstrap 5 Admin Dashboard**: https://github.com/zuramai/mazer
- **Alternatif SB Admin 2**: https://github.com/StartBootstrap/startbootstrap-sb-admin-2

## Struktur Database (4 Tabel Relasional)
1. `users` — Menyimpan data pengguna dengan 2 role (`admin` dan `pengunjung`).
2. `kategori_wisata` — CRUD master kategori destinasi wisata.
3. `destinasi_wisata` — CRUD katalog destinasi wisata, harga tiket, dan kuota pengunjung harian.
4. `pemesanan_tiket` — CRUD transaksi pemesanan tiket, status pembayaran, kode booking unik QR Code, dan status check-in.

## Akun Demo (Password: `password`)
- **Admin / Pengelola**: `admin@paali.com`
- **Petugas Loket (Admin 2)**: `petugas@paali.com`
- **Pengunjung 1**: `budi@gmail.com`
- **Pengunjung 2**: `siti@gmail.com`

## Cara Instalasi & Menjalankan di Lokal (XAMPP / Laragon)
1. Ekstrak folder `sistem-tiket-wisata-pa-ali` ke direktori kerja Anda (misal: `C:\laragon\www\wisata-pa-ali`).
2. Buka terminal di dalam folder projek, lalu jalankan:
   ```bash
   composer install
   ```
3. Buat database baru di MySQL/phpMyAdmin bernama **`db_wisata_pa_ali`**.
4. Jalankan migrasi dan seeder (atau import `database/wisata_pa_ali.sql`):
   ```bash
   php artisan migrate --seed
   ```
5. Jalankan server lokal:
   ```bash
   php artisan serve
   ```
6. Akses di browser: `http://127.0.0.1:8000`.
