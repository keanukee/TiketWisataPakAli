<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DestinasiWisata extends Model
{
    protected $table = 'destinasi_wisata';
    protected $fillable = [
        'kategori_id', 'kode_wisata', 'nama_wisata', 'lokasi',
        'harga_tiket', 'kuota_harian', 'deskripsi', 'gambar_url', 'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriWisata::class, 'kategori_id');
    }

    public function pemesanan()
    {
        return $this->hasMany(PemesananTiket::class, 'destinasi_id');
    }

    public function sisaKuotaTanggal(string $tanggal): int
    {
        $terpakai = $this->pemesanan()
            ->whereDate('tanggal_kunjungan', $tanggal)
            ->where('status_pembayaran', '!=', 'dibatalkan')
            ->sum('jumlah_tiket');

        return max(0, $this->kuota_harian - $terpakai);
    }
}
