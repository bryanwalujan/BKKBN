<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingDataMonitoring extends Model
{
    protected $fillable = [
        'target',
        'kecamatan_id',
        'kelurahan_id',
        'kartu_keluarga_id',
        'ibu_id',
        'balita_id',
        'nama',
        'kategori',
        'perkembangan_anak',
        'kunjungan_rumah',
        'frekuensi_kunjungan',
        'pemberian_pmt',
        'frekuensi_pmt',
        'status',
        'warna_badge',
        'tanggal_monitoring',
        'urutan',
        'status_aktif',
        'created_by',
        'status_verifikasi',
        'catatan',
        'original_id',
    ];

    protected $casts = [
        'kunjungan_rumah' => 'boolean',
        'pemberian_pmt' => 'boolean',
        'status_aktif' => 'boolean',
        'tanggal_monitoring' => 'date',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'balita_id');
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

    public function original()
    {
        return $this->belongsTo(DataMonitoring::class, 'original_id');
    }
}