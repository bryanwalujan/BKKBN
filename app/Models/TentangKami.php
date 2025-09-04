<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TentangKami extends Model
{
    protected $fillable = [
        'sub_judul',
        'judul_utama',
        'paragraf_1',
        'paragraf_2',
        'teks_tombol',
        'link_tombol',
        'gambar_utama',
        'gambar_overlay',
        'tanggal_update',
    ];

    protected $casts = [
        'tanggal_update' => 'datetime',
    ];
}