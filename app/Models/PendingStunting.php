<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PendingStunting extends Model
{
    use HasFactory;

    protected $table = 'pending_stuntings';
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
        'status',
        'created_by',
    ];

    protected $dates = ['tanggal_lahir'];

    protected $casts = [
        'jenis_kelamin' => 'string',
        'status_gizi' => 'string',
        'warna_gizi' => 'string',
        'warna_tindak_lanjut' => 'string',
        'tanggal_lahir' => 'date:Y-m-d',
        'status' => 'string',
    ];

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