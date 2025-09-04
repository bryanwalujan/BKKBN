<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Publikasi extends Model
{
    protected $fillable = [
        'judul',
        'kategori',
        'deskripsi',
        'gambar',
        'link_aksi',
        'teks_tombol',
        'urutan',
        'status_aktif',
        'tanggal_update',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'tanggal_update' => 'datetime',
    ];
}