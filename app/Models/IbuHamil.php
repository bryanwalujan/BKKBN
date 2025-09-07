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
        'berat',
        'tinggi',
    ];

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }
}