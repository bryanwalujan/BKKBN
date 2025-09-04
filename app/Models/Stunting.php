<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stunting extends Model
{
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_tinggi',
        'kelurahan',
        'kecamatan',
        'status_gizi',
        'warna_gizi',
        'tindak_lanjut',
        'warna_tindak_lanjut',
        'foto',
    ];

    protected $dates = ['tanggal_lahir'];
}