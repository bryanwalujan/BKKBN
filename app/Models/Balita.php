<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class Balita extends Model
{
    use HasFactory;

    protected $table = "balitas";
    protected $fillable = [
        'kartu_keluarga_id',
        'nik',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'berat_tinggi',
        'kecamatan_id',
        'kelurahan_id',
        'alamat',
        'status_gizi',
        'warna_label',
        'status_pemantauan',
        'foto',
        'lingkar_kepala',
        'lingkar_lengan',
        'created_by',
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
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    // Mutator untuk mengenkripsi NIK saat disimpan
    public function setNikAttribute($value)
    {
        if ($value && !empty(trim($value))) {
            $this->attributes['nik'] = Crypt::encryptString($value);
        } else {
            $this->attributes['nik'] = null;
        }
    }

    // Accessor untuk mendekripsi NIK saat diambil
    public function getNikAttribute($value)
    {
        
            try {
                return Crypt::decryptString($value);
            } catch (\Exception $e) {
                \Log::error('Gagal mendekripsi NIK untuk balita ID' . $e->getMessage(), ['id' => $this->id]);
                return $value; // atau kembalikan string kosong: ''
            }
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

        
    }
