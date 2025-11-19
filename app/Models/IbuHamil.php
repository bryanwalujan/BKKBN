<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuHamil extends Model
{
    protected $table = 'ibu_hamils';
    protected $fillable = [
        'ibu_id',
        'trimester',
        'intervensi',
        'status_gizi',
        'warna_status_gizi',
        'usia_kehamilan',
        'tinggi_fundus_uteri',
        'imt',
        'riwayat_penyakit',
        'kadar_hb',
        'lingkar_kepala',
        'taksiran_berat_janin',
        'berat',
        'tinggi',
    ];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }
}