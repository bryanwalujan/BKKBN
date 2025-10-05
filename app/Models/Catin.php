<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Catin extends Model
{
    use HasFactory;

    protected $fillable = [
        'hari_tanggal',
        'catin_wanita_nama',
        'catin_wanita_nik',
        'catin_wanita_tempat_lahir',
        'catin_wanita_tgl_lahir',
        'catin_wanita_no_hp',
        'catin_wanita_alamat',
        'catin_pria_nama',
        'catin_pria_nik',
        'catin_pria_tempat_lahir',
        'catin_pria_tgl_lahir',
        'catin_pria_no_hp',
        'catin_pria_alamat',
        'tanggal_pernikahan',
        'berat_badan',
        'tinggi_badan',
        'imt',
        'kadar_hb',
        'merokok',
        'created_by',
    ];

    protected $casts = [
        'hari_tanggal' => 'date',
        'catin_wanita_tgl_lahir' => 'date',
        'catin_pria_tgl_lahir' => 'date',
        'tanggal_pernikahan' => 'date',
        'catin_wanita_nik' => 'encrypted',
        'catin_wanita_no_hp' => 'encrypted',
        'catin_pria_nik' => 'encrypted',
        'catin_pria_no_hp' => 'encrypted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}