<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ibu extends Model
{
    protected $table = 'ibus';
    protected $fillable = [
        'nik',
        'nama',
        'kecamatan_id',
        'kelurahan_id',
        'kartu_keluarga_id',
        'alamat',
        'status',
        'foto',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function ibuHamil()
    {
        return $this->hasOne(IbuHamil::class, 'ibu_id');
    }

    public function ibuNifas()
    {
        return $this->hasOne(IbuNifas::class, 'ibu_id');
    }

    public function ibuMenyusui()
    {
        return $this->hasOne(IbuMenyusui::class, 'ibu_id');
    }
}