<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Balita extends Model
{
    use HasFactory;

    protected $table = 'balitas';
    protected $fillable = [
        'kartu_keluarga_id',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'kecamatan_id',
        'kelurahan_id',
        'berat_tinggi',
        'lingkar_kepala',
        'lingkar_lengan',
        'alamat',
        'status_gizi',
        'warna_label',
        'status_pemantauan',
        'foto',
    ];

    protected $dates = ['tanggal_lahir'];

    protected $casts = [
        'jenis_kelamin' => 'string',
        'status_gizi' => 'string',
        'warna_label' => 'string',
        'tanggal_lahir' => 'date:Y-m-d',
        'lingkar_kepala' => 'float',
        'lingkar_lengan' => 'float',
    ];

    // Accessor untuk menghitung usia dalam bulan (dibulatkan)
    public function getUsiaAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }
        return round(Carbon::parse($this->tanggal_lahir)->diffInMonths(Carbon::now()));
    }

    // Accessor untuk menentukan kategori umur
    public function getKategoriUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
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