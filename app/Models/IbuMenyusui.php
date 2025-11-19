<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuMenyusui extends Model
{
    protected $table = 'ibu_menyusuis';
    protected $fillable = [
        'ibu_id',
        'status_menyusui',
        'frekuensi_menyusui',
        'kondisi_ibu',
        'warna_kondisi',
        'berat',
        'tinggi',
    ];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }
}