<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingKartuKeluarga extends Model
{
    protected $fillable = [
        'no_kk',
        'kepala_keluarga',
        'kecamatan_id',
        'kelurahan_id',
        'alamat',
        'latitude',
        'longitude',
        'status',
        'status_verifikasi',
        'created_by',
        'original_kartu_keluarga_id',
        'catatan',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'status' => 'string',
        'status_verifikasi' => 'string',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function originalKartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'original_kartu_keluarga_id');
    }
}