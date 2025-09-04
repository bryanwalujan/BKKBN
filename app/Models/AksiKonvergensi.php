<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksiKonvergensi extends Model
{
    protected $fillable = [
        'kecamatan',
        'kelurahan',
        'nama_aksi',
        'selesai',
        'tahun',
        'foto',
    ];

    protected $casts = [
        'selesai' => 'boolean',
    ];
}