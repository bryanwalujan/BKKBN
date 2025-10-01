<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingIbu extends Model
{
    protected $table = 'pending_ibus';
    protected $fillable = [
        'nik',
        'nama',
        'kecamatan_id',
        'kelurahan_id',
        'kartu_keluarga_id',
        'alamat',
        'status',
        'foto',
        'created_by',
        'status_verifikasi',
        'original_ibu_id',
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pendingIbuHamil()
    {
        return $this->hasOne(PendingIbuHamil::class, 'pending_ibu_id');
    }

    public function pendingIbuNifas()
    {
        return $this->hasOne(PendingIbuNifas::class, 'pending_ibu_id');
    }
}