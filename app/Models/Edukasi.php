<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    protected $table = 'edukasi';
    protected $fillable = [
        'judul',
        'penyebaran_informasi_media',
        'konseling_perubahan_perilaku',
        'konseling_pengasuhan',
        'paud',
        'konseling_kesehatan_reproduksi',
        'ppa',
        'modul_buku_saku',
        'gambar',
        'status_aktif',
    ];
}