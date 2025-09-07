<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemajaPutri extends Model
{
    protected $fillable = [
        'nama',
        'kartu_keluarga_id',
        'kecamatan_id',
        'kelurahan_id',
        'sekolah',
        'kelas',
        'umur',
        'status_anemia',
        'konsumsi_ttd',
        'foto',
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