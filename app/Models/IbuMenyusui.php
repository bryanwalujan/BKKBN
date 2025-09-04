<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuMenyusui extends Model
{
    protected $fillable = [
        'nama',
        'kelurahan',
        'kecamatan',
        'status_menyusui',
        'frekuensi_menyusui',
        'kondisi_ibu',
        'warna_kondisi',
        'berat',
        'tinggi',
        'foto',
    ];
}