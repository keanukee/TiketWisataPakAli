<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PemesananTiket extends Model
{
    protected $table = 'pemesanan_tiket';
    protected $fillable = [
        'kode_booking', 'user_id', 'destinasi_id', 'tanggal_kunjungan',
        'jumlah_tiket', 'total_harga', 'metode_pembayaran',
        'status_pembayaran', 'status_checkin', 'catatan',
    ];
    protected $casts = ['tanggal_kunjungan' => 'date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function destinasi()
    {
        return $this->belongsTo(DestinasiWisata::class, 'destinasi_id');
    }
}
