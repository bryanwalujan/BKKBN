<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingGenting extends Model
{
    protected $table = 'pending_gentings';

    protected $fillable = [
        'kartu_keluarga_id',
        'kecamatan_id',
        'created_by',
        'status',
        'original_genting_id',
        'catatan',
        'nama_kegiatan',
        'tanggal',
        'lokasi',
        'sasaran',
        'jenis_intervensi',
        'narasi',
        'dokumentasi',
        'dunia_usaha',
        'dunia_usaha_frekuensi',
        'pemerintah',
        'pemerintah_frekuensi',
        'bumn_bumd',
        'bumn_bumd_frekuensi',
        'individu_perseorangan',
        'individu_perseorangan_frekuensi',
        'lsm_komunitas',
        'lsm_komunitas_frekuensi',
        'swasta',
        'swasta_frekuensi',
        'perguruan_tinggi_akademisi',
        'perguruan_tinggi_akademisi_frekuensi',
        'media',
        'media_frekuensi',
        'tim_pendamping_keluarga',
        'tim_pendamping_keluarga_frekuensi',
        'tokoh_masyarakat',
        'tokoh_masyarakat_frekuensi',
    ];

    protected $dates = ['tanggal'];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}