<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamil extends Model
{
    protected $fillable = [
        'nama',
        'kelurahan',
        'kecamatan',
        'trimester',
        'intervensi',
        'status_gizi',
        'warna_status_gizi',
        'usia_kehamilan',
        'berat',
        'tinggi',
        'foto',
    ];
}