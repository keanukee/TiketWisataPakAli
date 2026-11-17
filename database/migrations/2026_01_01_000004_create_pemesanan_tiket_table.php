<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pemesanan_tiket', function (Blueprint $table) {
            $table->id();
            $table->string('kode_booking', 30)->unique();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('destinasi_id')->constrained('destinasi_wisata')->onDelete('cascade');
            $table->date('tanggal_kunjungan');
            $table->integer('jumlah_tiket');
            $table->decimal('total_harga', 12, 2);
            $table->enum('metode_pembayaran', ['QRIS', 'Transfer VA', 'E-Wallet', 'Bayar di Loket'])->default('QRIS');
            $table->enum('status_pembayaran', ['pending', 'lunas', 'dibatalkan'])->default('pending');
            $table->enum('status_checkin', ['belum_checkin', 'sudah_checkin'])->default('belum_checkin');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan_tiket');
    }
};
