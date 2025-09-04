<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananKami extends Model
{
    protected $fillable = [
        'judul_layanan',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'ikon',
        'urutan',
        'status_aktif',
        'tanggal_update',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'tanggal_update' => 'datetime',
    ];
}