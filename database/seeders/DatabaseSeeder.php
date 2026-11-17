<?php

namespace Database\Seeders;

use App\Models\DestinasiWisata;
use App\Models\KategoriWisata;
use App\Models\PemesananTiket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Pa Ali (Admin Pengelola)',
            'email' => 'admin@paali.com',
            'no_hp' => '081275001122',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => 'Rina Petugas Loket',
            'email' => 'petugas@paali.com',
            'no_hp' => '081275003344',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $pengunjung1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@gmail.com',
            'no_hp' => '082288990011',
            'role' => 'pengunjung',
            'password' => Hash::make('password'),
        ]);

        $pengunjung2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'no_hp' => '085266778899',
            'role' => 'pengunjung',
            'password' => Hash::make('password'),
        ]);

        $katAlam = KategoriWisata::create([
            'nama_kategori' => 'Wisata Alam & Taman',
            'ikon' => 'bi-tree-fill',
            'deskripsi' => 'Panorama alam asri, taman bunga, dan spot foto keluarga Pa Ali.',
        ]);

        $katAir = KategoriWisata::create([
            'nama_kategori' => 'Wahana Air & Kolam',
            'ikon' => 'bi-water',
            'deskripsi' => 'Kolam renang alami, bebek dayung, dan pemancingan keluarga.',
        ]);

        $katCamp = KategoriWisata::create([
            'nama_kategori' => 'Camping & Outbound',
            'ikon' => 'bi-fire',
            'deskripsi' => 'Area berkemah, flying fox, dan kegiatan gathering kelompok.',
        ]);

        $katEdukasi = KategoriWisata::create([
            'nama_kategori' => 'Agrowisata & Kuliner',
            'ikon' => 'bi-cup-hot-fill',
            'deskripsi' => 'Petik buah segar langsung dari kebun Pa Ali dan saung kuliner khas.',
        ]);

        $d1 = DestinasiWisata::create([
            'kategori_id' => $katAlam->id,
            'kode_wisata' => 'WPA-001',
            'nama_wisata' => 'Taman Bukit Pa Ali & Gardu Pandang',
            'lokasi' => 'Zona Utama Bukit Hijau, Kampar - Riau',
            'harga_tiket' => 25000,
            'kuota_harian' => 150,
            'deskripsi' => 'Nikmati pemandangan perbukitan hijau dari gardu pandang kayu, jembatan gantung, serta taman bunga warna-warni yang instagramable.',
            'gambar_url' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80',
            'status' => 'aktif',
        ]);

        $d2 = DestinasiWisata::create([
            'kategori_id' => $katAir->id,
            'kode_wisata' => 'WPA-002',
            'nama_wisata' => 'Danau Buatan & Wahana Sepeda Air Pa Ali',
            'lokasi' => 'Zona Danau Selatan, Wisata Pa Ali',
            'harga_tiket' => 35000,
            'kuota_harian' => 100,
            'deskripsi' => 'Tiket terusan masuk area danau buatan lengkap dengan wahana bebek air, perahu kano, dan gazebo tepi air.',
            'gambar_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80',
            'status' => 'aktif',
        ]);

        $d3 = DestinasiWisata::create([
            'kategori_id' => $katCamp->id,
            'kode_wisata' => 'WPA-003',
            'nama_wisata' => 'Bumi Perkemahan Pinus Pa Ali',
            'lokasi' => 'Zona Hutan Pinus Utara, Wisata Pa Ali',
            'harga_tiket' => 50000,
            'kuota_harian' => 60,
            'deskripsi' => 'Paket camping ground 2 hari 1 malam sudah termasuk akses listrik, musholla, kamar bilas bersih, dan area api unggun.',
            'gambar_url' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=800&q=80',
            'status' => 'aktif',
        ]);

        $d4 = DestinasiWisata::create([
            'kategori_id' => $katEdukasi->id,
            'kode_wisata' => 'WPA-004',
            'nama_wisata' => 'Kebun Petik Jeruk & Saung Kuliner Pa Ali',
            'lokasi' => 'Zona Agrowisata Timur, Wisata Pa Ali',
            'harga_tiket' => 20000,
            'kuota_harian' => 120,
            'deskripsi' => 'Wisata edukasi memetik buah jeruk dan jambu madu langsung dari pohonnya serta menikmati hidangan ikan bakar khas Riau.',
            'gambar_url' => 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=800&q=80',
            'status' => 'aktif',
        ]);

        PemesananTiket::create([
            'kode_booking' => 'TKT-PAALI-2026001',
            'user_id' => $pengunjung1->id,
            'destinasi_id' => $d1->id,
            'tanggal_kunjungan' => now()->addDays(2)->toDateString(),
            'jumlah_tiket' => 3,
            'total_harga' => 75000,
            'metode_pembayaran' => 'QRIS',
            'status_pembayaran' => 'lunas',
            'status_checkin' => 'belum_checkin',
            'catatan' => 'Liburan akhir pekan bersama keluarga.',
        ]);

        PemesananTiket::create([
            'kode_booking' => 'TKT-PAALI-2026002',
            'user_id' => $pengunjung1->id,
            'destinasi_id' => $d2->id,
            'tanggal_kunjungan' => now()->addDays(5)->toDateString(),
            'jumlah_tiket' => 2,
            'total_harga' => 70000,
            'metode_pembayaran' => 'Transfer VA',
            'status_pembayaran' => 'pending',
            'status_checkin' => 'belum_checkin',
            'catatan' => 'Mohon disiapkan pelampung anak.',
        ]);

        PemesananTiket::create([
            'kode_booking' => 'TKT-PAALI-2026003',
            'user_id' => $pengunjung2->id,
            'destinasi_id' => $d3->id,
            'tanggal_kunjungan' => now()->toDateString(),
            'jumlah_tiket' => 4,
            'total_harga' => 200000,
            'metode_pembayaran' => 'E-Wallet',
            'status_pembayaran' => 'lunas',
            'status_checkin' => 'sudah_checkin',
            'catatan' => 'Rombongan mahasiswa PCR.',
        ]);
    }
}
