<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    protected $table = 'edukasi';
    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'tautan',
        'file',
        'gambar',
        'status_aktif',
    ];

    public const KATEGORI = [
        'penyebaran_informasi_media' => 'Penyebaran Informasi melalui Media',
        'konseling_perubahan_perilaku' => 'Konseling Perubahan Perilaku Antar Pribadi',
        'konseling_pengasuhan' => 'Konseling Pengasuhan untuk Orang Tua',
        'paud' => 'PAUD (Pendidikan Anak Usia Dini)',
        'konseling_kesehatan_reproduksi' => 'Konseling Kesehatan Reproduksi untuk Remaja',
        'ppa' => 'PPA (Pemberdayaan Perempuan dan Perlindungan Anak)',
        'modul_buku_saku' => 'Modul dan Buku Saku Pencegahan dan Penanganan Stunting',
    ];
}