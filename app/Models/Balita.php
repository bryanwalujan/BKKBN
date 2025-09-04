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
        'kecamatan_id',
        'kelurahan_id',
        'alamat',
        'status_gizi',
        'warna_label',
        'status_pemantauan',
        'foto',
        'kartu_keluarga_id',
    ];

    protected $dates = ['tanggal_lahir'];

    protected $casts = [
        'jenis_kelamin' => 'string',
        'status_gizi' => 'string',
        'warna_label' => 'string',
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}