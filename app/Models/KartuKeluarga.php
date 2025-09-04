<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $fillable = [
        'no_kk',
        'kepala_keluarga',
        'kecamatan',
        'kelurahan',
        'alamat',
        'latitude',
        'longitude',
        'status',
    ];

    public function balitas()
    {
        return $this->hasMany(Balita::class);
    }
}