<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PetaGeospasial extends Model
{
    protected $fillable = [
        'nama_lokasi',
        'kecamatan_id',
        'kelurahan_id',
        'status',
        'latitude',
        'longitude',
        'jenis',
        'warna_marker',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}