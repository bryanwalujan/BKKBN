<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPendampingKeluarga extends Model
{
    use HasFactory;

    protected $table = 'pending_pendamping_keluargas';

    protected $fillable = [
        'nama',
        'peran',
        'kecamatan_id',
        'kelurahan_id',
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
        'status_verifikasi',
        'original_id',
    ];

    public function kartuKeluargas()
    {
        return $this->belongsToMany(KartuKeluarga::class, 'pending_kartu_keluarga_pendamping', 'pending_pendamping_keluarga_id', 'kartu_keluarga_id')
                    ->withTimestamps();
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}