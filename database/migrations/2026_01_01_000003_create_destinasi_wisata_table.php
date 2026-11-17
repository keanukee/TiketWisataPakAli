<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('destinasi_wisata', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_wisata')->onDelete('cascade');
            $table->string('kode_wisata', 20)->unique();
            $table->string('nama_wisata', 150);
            $table->string('lokasi', 150);
            $table->decimal('harga_tiket', 12, 2);
            $table->integer('kuota_harian')->default(100);
            $table->text('deskripsi')->nullable();
            $table->string('gambar_url')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('destinasi_wisata');
    }
};
