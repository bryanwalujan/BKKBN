<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referensi extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi',
        'icon',
        'pdf',
        'warna_icon',
        'link_file',
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