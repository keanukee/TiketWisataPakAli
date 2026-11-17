-- Database: db_wisata_pa_ali
CREATE DATABASE IF NOT EXISTS `db_wisata_pa_ali` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `db_wisata_pa_ali`;

DROP TABLE IF EXISTS `pemesanan_tiket`;
DROP TABLE IF EXISTS `destinasi_wisata`;
DROP TABLE IF EXISTS `kategori_wisata`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `role` enum('admin','pengunjung') NOT NULL DEFAULT 'pengunjung',
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `kategori_wisata` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) NOT NULL,
  `ikon` varchar(50) NOT NULL DEFAULT 'bi-compass',
  `deskripsi` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `destinasi_wisata` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `kode_wisata` varchar(20) NOT NULL,
  `nama_wisata` varchar(150) NOT NULL,
  `lokasi` varchar(150) NOT NULL,
  `harga_tiket` decimal(12,2) NOT NULL,
  `kuota_harian` int(11) NOT NULL DEFAULT 100,
  `deskripsi` text DEFAULT NULL,
  `gambar_url` varchar(255) DEFAULT NULL,
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `destinasi_wisata_kode_wisata_unique` (`kode_wisata`),
  CONSTRAINT `destinasi_wisata_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_wisata` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `pemesanan_tiket` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kode_booking` varchar(30) NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `destinasi_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_kunjungan` date NOT NULL,
  `jumlah_tiket` int(11) NOT NULL,
  `total_harga` decimal(12,2) NOT NULL,
  `metode_pembayaran` enum('QRIS','Transfer VA','E-Wallet','Bayar di Loket') NOT NULL DEFAULT 'QRIS',
  `status_pembayaran` enum('pending','lunas','dibatalkan') NOT NULL DEFAULT 'pending',
  `status_checkin` enum('belum_checkin','sudah_checkin') NOT NULL DEFAULT 'belum_checkin',
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pemesanan_tiket_kode_booking_unique` (`kode_booking`),
  CONSTRAINT `pemesanan_tiket_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pemesanan_tiket_destinasi_id_foreign` FOREIGN KEY (`destinasi_id`) REFERENCES `destinasi_wisata` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `no_hp`, `role`, `password`) VALUES
(1, 'Pa Ali (Admin Pengelola)', 'admin@paali.com', '081275001122', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'Rina Petugas Loket', 'petugas@paali.com', '081275003344', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'Budi Santoso', 'budi@gmail.com', '082288990011', 'pengunjung', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(4, 'Siti Aminah', 'siti@gmail.com', '085266778899', 'pengunjung', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO `kategori_wisata` (`id`, `nama_kategori`, `ikon`, `deskripsi`) VALUES
(1, 'Wisata Alam & Taman', 'bi-tree-fill', 'Panorama alam asri, taman bunga, dan spot foto keluarga Pa Ali.'),
(2, 'Wahana Air & Kolam', 'bi-water', 'Kolam renang alami, bebek dayung, dan pemancingan keluarga.'),
(3, 'Camping & Outbound', 'bi-fire', 'Area berkemah, flying fox, dan kegiatan gathering kelompok.'),
(4, 'Agrowisata & Kuliner', 'bi-cup-hot-fill', 'Petik buah segar langsung dari kebun Pa Ali dan saung kuliner khas.');

INSERT INTO `destinasi_wisata` (`id`, `kategori_id`, `kode_wisata`, `nama_wisata`, `lokasi`, `harga_tiket`, `kuota_harian`, `deskripsi`, `gambar_url`, `status`) VALUES
(1, 1, 'WPA-001', 'Taman Bukit Pa Ali & Gardu Pandang', 'Zona Utama Bukit Hijau, Kampar - Riau', 25000.00, 150, 'Nikmati pemandangan perbukitan hijau dari gardu pandang kayu, jembatan gantung, serta taman bunga warna-warni.', 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=800&q=80', 'aktif'),
(2, 2, 'WPA-002', 'Danau Buatan & Wahana Sepeda Air Pa Ali', 'Zona Danau Selatan, Wisata Pa Ali', 35000.00, 100, 'Tiket terusan masuk area danau buatan lengkap dengan wahana bebek air, perahu kano, dan gazebo tepi air.', 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=80', 'aktif'),
(3, 3, 'WPA-003', 'Bumi Perkemahan Pinus Pa Ali', 'Zona Hutan Pinus Utara, Wisata Pa Ali', 50000.00, 60, 'Paket camping ground 2 hari 1 malam sudah termasuk akses listrik, musholla, kamar bilas bersih, dan area api unggun.', 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=800&q=80', 'aktif'),
(4, 4, 'WPA-004', 'Kebun Petik Jeruk & Saung Kuliner Pa Ali', 'Zona Agrowisata Timur, Wisata Pa Ali', 20000.00, 120, 'Wisata edukasi memetik buah jeruk dan jambu madu langsung dari pohonnya serta menikmati hidangan ikan bakar.', 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?auto=format&fit=crop&w=800&q=80', 'aktif');

INSERT INTO `pemesanan_tiket` (`id`, `kode_booking`, `user_id`, `destinasi_id`, `tanggal_kunjungan`, `jumlah_tiket`, `total_harga`, `metode_pembayaran`, `status_pembayaran`, `status_checkin`, `catatan`) VALUES
(1, 'TKT-PAALI-2026001', 3, 1, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 3, 75000.00, 'QRIS', 'lunas', 'belum_checkin', 'Liburan akhir pekan bersama keluarga.'),
(2, 'TKT-PAALI-2026002', 3, 2, DATE_ADD(CURDATE(), INTERVAL 5 DAY), 2, 70000.00, 'Transfer VA', 'pending', 'belum_checkin', 'Mohon disiapkan pelampung anak.'),
(3, 'TKT-PAALI-2026003', 4, 3, CURDATE(), 4, 200000.00, 'E-Wallet', 'lunas', 'sudah_checkin', 'Rombongan mahasiswa PCR.');
