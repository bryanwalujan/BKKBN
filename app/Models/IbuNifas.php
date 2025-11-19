<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuNifas extends Model
{
    protected $table = 'ibu_nifas';
    protected $fillable = [
        'ibu_id',
        'hari_nifas',
        'tanggal_melahirkan',
        'tempat_persalinan',
        'penolong_persalinan',
        'cara_persalinan',
        'komplikasi',
        'keadaan_bayi',
        'kb_pasca_salin',
        'kondisi_kesehatan',
        'warna_kondisi',
        'berat',
        'tinggi',
    ];

    protected $dates = ['tanggal_melahirkan'];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }

    public function bayiBaruLahir()
    {
        return $this->hasOne(BayiBaruLahir::class, 'ibu_nifas_id');
    }
}