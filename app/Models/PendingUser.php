<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    protected $fillable = [
        'name', 'email', 'password', 'role', 'kecamatan_id', 'kelurahan_id', 
        'penanggung_jawab', 'no_telepon', 'pas_foto', 'surat_pengajuan', 'status'
    ];

    protected $casts = [];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}