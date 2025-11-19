<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendampingKeluarga extends Model
{
    protected $table = 'pendamping_keluargas';
    protected $fillable = [
        'nama',
        'peran',
        'kelurahan_id',
        'kecamatan_id',
        'status',
        'tahun_bergabung',
        'foto',
        'penyuluhan',
        'penyuluhan_frekuensi',
        'rujukan',
        'rujukan_frekuensi',
        'kunjungan_krs',
        'kunjungan_krs_frekuensi',
        'pendataan_bansos',
        'pendataan_bansos_frekuensi',
        'pemantauan_kesehatan',
        'pemantauan_kesehatan_frekuensi',
        'created_by',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function kartuKeluargas()
    {
        return $this->belongsToMany(KartuKeluarga::class, 'kartu_keluarga_pendamping')
                    ->withTimestamps();
    }

    public function laporan()
    {
        return $this->hasMany(LaporanPendamping::class, 'pendamping_keluarga_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}