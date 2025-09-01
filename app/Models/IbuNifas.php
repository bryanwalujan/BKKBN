<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuNifas extends Model
{
    protected $fillable = [
        'nama',
        'kelurahan',
        'kecamatan',
        'hari_nifas',
        'kondisi_kesehatan',
        'warna_kondisi',
        'berat',
        'tinggi',
        'foto',
    ];
}