<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_tinggi',
        'kelurahan',
        'kecamatan',
        'status_gizi',
        'warna_label',
        'status_pemantauan',
        'foto',
    ];

    protected $dates = ['tanggal_lahir'];
}