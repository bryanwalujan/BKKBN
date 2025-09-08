<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'kecamatan_id', 'kelurahan_id', 'penanggung_jawab', 'no_telepon', 'pas_foto', 'email_verified_at'
    ];

    protected $hidden = [
        'password', 'remember_token', 'penanggung_jawab', 'no_telepon'
    ];

    protected $casts = [
        'penanggung_jawab' => 'encrypted',
        'no_telepon' => 'encrypted',
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function getKecamatanNamaAttribute()
    {
        return $this->kecamatan ? $this->kecamatan->nama_kecamatan : null;
    }

    public function isMaster()
    {
        return $this->role === 'master';
    }

    public function isAdminKelurahan()
    {
        return $this->role === 'admin_kelurahan';
    }

    public function isPerangkatDaerah()
    {
        return $this->role === 'perangkat_daerah';
    }
}