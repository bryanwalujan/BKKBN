<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetaGeospasial extends Model
{
    protected $fillable = [
        'nama_lokasi',
        'kecamatan',
        'kelurahan',
        'status',
        'latitude',
        'longitude',
        'jenis',
        'warna_marker',
    ];
}