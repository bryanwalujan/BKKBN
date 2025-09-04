<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'kelurahan_id', 'kelurahan_nama', 'penanggung_jawab', 'no_telepon', 'pas_foto', 'surat_pengajuan', 'status', 'catatan'
    ];

public function getKecamatanNamaAttribute()
    {
        return null; // Belum ada kecamatan_id di pending_users
    }

}