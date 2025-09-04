<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $fillable = [
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_tinggi',
        'kecamatan',
        'kelurahan',
        'alamat',
        'status_gizi',
        'warna_label',
        'status_pemantauan',
        'foto',
    ];

    protected $dates = ['tanggal_lahir'];

    protected $casts = [
        'jenis_kelamin' => 'string', // Enum Laki-laki, Perempuan
        'status_gizi' => 'string',   // Enum Sehat, Stunting, Kurang Gizi, Obesitas
        'warna_label' => 'string',   // Enum Sehat, Waspada, Bahaya
    ];
}