<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class Stunting extends Model
{
    use HasFactory;

    protected $table = 'stuntings';
    protected $fillable = [
        'kartu_keluarga_id',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_tinggi',
        'kecamatan_id',
        'kelurahan_id',
        'status_gizi',
        'warna_gizi',
        'tindak_lanjut',
        'warna_tindak_lanjut',
        'foto',
        'created_by',
    ];

    protected $dates = ['tanggal_lahir'];

    protected $casts = [
        'jenis_kelamin' => 'string',
        'status_gizi' => 'string',
        'warna_gizi' => 'string',
        'warna_tindak_lanjut' => 'string',
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    // Accessor untuk mendekripsi NIK
    public function getNikAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Gagal mendekripsi NIK: ' . $e->getMessage(), ['nik' => $value]);
            return null;
        }
    }

    // Mutator untuk mengenkripsi NIK
    public function setNikAttribute($value)
    {
        $this->attributes['nik'] = $value ? Crypt::encryptString($value) : null;
    }

    // Accessor untuk menghitung usia
    public function getUsiaAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        return Carbon::parse($this->tanggal_lahir)->age;
    }

    // Accessor untuk menentukan kategori umur
    public function getKategoriUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return 'Tidak Diketahui';
        }
        $usia = $this->usia;
        if ($usia >= 0 && $usia <= 2) {
            return 'Baduata';
        } elseif ($usia > 2 && $usia <= 6) {
            return 'Balita';
        }
        return 'Di Atas Balita';
    }

    // Relasi
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
}