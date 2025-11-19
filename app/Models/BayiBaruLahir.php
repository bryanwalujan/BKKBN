<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BayiBaruLahir extends Model
{
    protected $table = 'bayi_baru_lahir';
    protected $fillable = [
        'ibu_nifas_id',
        'umur_dalam_kandungan',
        'berat_badan_lahir',
        'panjang_badan_lahir',
    ];

    public function ibuNifas()
    {
        return $this->belongsTo(IbuNifas::class, 'ibu_nifas_id');
    }
}