<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriWisata extends Model
{
    protected $table = 'kategori_wisata';
    protected $fillable = ['nama_kategori', 'ikon', 'deskripsi'];

    public function destinasi()
    {
        return $this->hasMany(DestinasiWisata::class, 'kategori_id');
    }
}
