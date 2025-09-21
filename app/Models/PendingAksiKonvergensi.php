<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingAksiKonvergensi extends Model
{
    protected $table = 'pending_aksi_konvergensis';

    protected $fillable = [
        'kartu_keluarga_id',
        'kelurahan_id',
        'created_by',
        'status',
        'catatan',
        'original_aksi_konvergensi_id',
        'nama_aksi',
        'selesai',
        'tahun',
        'foto',
        'air_bersih_sanitasi',
        'akses_layanan_kesehatan_kb',
        'pendidikan_pengasuhan_ortu',
        'edukasi_kesehatan_remaja',
        'kesadaran_pengasuhan_gizi',
        'akses_pangan_bergizi',
        'makanan_ibu_hamil',
        'tablet_tambah_darah',
        'inisiasi_menyusui_dini',
        'asi_eksklusif',
        'asi_mpasi',
        'imunisasi_lengkap',
        'pencegahan_infeksi',
        'status_gizi_ibu',
        'penyakit_menular',
        'jenis_penyakit',
        'kesehatan_lingkungan',
        'narasi',
        'pelaku_aksi',
        'waktu_pelaksanaan',
    ];

    protected $casts = [
        'selesai' => 'boolean',
        'waktu_pelaksanaan' => 'datetime',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}