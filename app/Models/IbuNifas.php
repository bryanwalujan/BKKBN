<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IbuNifas extends Model
{
    protected $table = 'ibu_nifas';
    protected $fillable = [
        'ibu_id',
        'hari_nifas',
        'kondisi_kesehatan',
        'warna_kondisi',
        'berat',
        'tinggi',
    ];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }
}