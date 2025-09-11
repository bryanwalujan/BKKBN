<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AksiKonvergensi extends Model
{
    protected $fillable = [
        'kartu_keluarga_id',
        'kecamatan_id',
        'kelurahan_id',
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
        'akses_layanan_kesehatan_kb' => 'boolean',
        'pendidikan_pengasuhan_ortu' => 'boolean',
        'edukasi_kesehatan_remaja' => 'boolean',
        'kesadaran_pengasuhan_gizi' => 'boolean',
        'akses_pangan_bergizi' => 'boolean',
        'makanan_ibu_hamil' => 'boolean',
        'tablet_tambah_darah' => 'boolean',
        'inisiasi_menyusui_dini' => 'boolean',
        'asi_eksklusif' => 'boolean',
        'asi_mpasi' => 'boolean',
        'imunisasi_lengkap' => 'boolean',
        'pencegahan_infeksi' => 'boolean',
        'waktu_pelaksanaan' => 'datetime',
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
}