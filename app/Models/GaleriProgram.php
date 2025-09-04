<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriProgram extends Model
{
    protected $fillable = [
        'gambar',
        'judul',
        'deskripsi',
        'kategori',
        'link',
        'urutan',
        'status_aktif',
        'tanggal_update',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'tanggal_update' => 'datetime',
    ];
}