<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataMonitoring extends Model
{
    protected $fillable = [
        'nama',
        'kelurahan',
        'kategori',
        'balita',
        'status',
        'warna_badge',
        'tanggal_monitoring',
        'urutan',
        'status_aktif',
        'tanggal_update',
    ];

    protected $casts = [
        'status_aktif' => 'boolean',
        'tanggal_monitoring' => 'date',
        'tanggal_update' => 'datetime',
    ];
}