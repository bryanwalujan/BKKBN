<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class KartuKeluarga extends Model
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
        'marker_color',
        'created_by',
    ];

    // Mutator untuk mengenkripsi no_kk saat disimpan
    public function setNoKkAttribute($value)
    {
        $this->attributes['no_kk'] = Crypt::encryptString($value);
    }

    // Accessor untuk mendekripsi no_kk saat diambil
    public function getNoKkAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            \Log::error('Failed to decrypt no_kk: ' . $e->getMessage(), ['id' => $this->id]);
            return $value; // Kembalikan nilai asli jika dekripsi gagal
        }
    }

    public function balitas()
    {
        return $this->hasMany(Balita::class);
    }

    public function ibu()
    {
        return $this->hasMany(Ibu::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function aksiKonvergensis()
    {
        return $this->hasMany(AksiKonvergensi::class);
    }

    public function gentings()
    {
        return $this->hasMany(Genting::class);
    }

    public function dataMonitorings()
    {
        return $this->hasMany(DataMonitoring::class, 'kartu_keluarga_id');
    }

    public function pendampingKeluargas()
    {
        return $this->belongsToMany(PendampingKeluarga::class, 'kartu_keluarga_pendamping')
                    ->withTimestamps();
    }

    public function laporan()
    {
        return $this->hasMany(LaporanPendamping::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}