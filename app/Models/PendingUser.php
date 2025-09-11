<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'kecamatan_id', 'kelurahan_id', 'penanggung_jawab', 'no_telepon', 'pas_foto', 'surat_pengajuan', 'status'
    ];

    protected $casts = [
        'penanggung_jawab' => 'encrypted',
        'no_telepon' => 'encrypted',
    ];
}