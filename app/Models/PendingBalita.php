<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PendingBalita extends Model
{
    protected $fillable = [
        'kartu_keluarga_id', 'nik', 'nama', 'tanggal_lahir', 'jenis_kelamin',
        'kecamatan_id', 'kelurahan_id', 'berat_tinggi', 'lingkar_kepala', 'lingkar_lengan',
        'alamat', 'status_gizi', 'warna_label', 'status_pemantauan', 'foto',
        'status', 'created_by', 'catatan', 'original_balita_id'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date:Y-m-d',
        'lingkar_kepala' => 'float',
        'lingkar_lengan' => 'float',
        'status' => 'string',
        'warna_label' => 'string',
        'status_gizi' => 'string',
        'jenis_kelamin' => 'string',
    ];

    // Accessor untuk menghitung usia dalam bulan (dibulatkan)
    public function getUsiaAttribute()
    {
        if (!$this->tanggal_lahir || $this->tanggal_lahir->isFuture()) {
            return null;
        }
        return round(Carbon::parse($this->tanggal_lahir)->diffInMonths(Carbon::now()));
    }

    // Accessor untuk menentukan kategori umur
    public function getKategoriUmurAttribute()
    {
        if (!$this->usia) {
            return 'Tidak Diketahui';
        }
        $usiaBulan = $this->usia;
        if ($usiaBulan >= 0 && $usiaBulan <= 24) {
            return 'Baduata';
        } elseif ($usiaBulan > 24 && $usiaBulan <= 60) {
            return 'Balita';
        }
        return 'Di Atas Balita';
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function originalBalita()
    {
        return $this->belongsTo(Balita::class, 'original_balita_id');
    }
}