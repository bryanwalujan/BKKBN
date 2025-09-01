<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'kelurahan_id', 'penanggung_jawab', 'no_telepon', 'pas_foto'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function isMaster()
    {
        return $this->role === 'master';
    }

    public function isAdminKelurahan()
    {
        return $this->role === 'admin_kelurahan';
    }

    public function isPerangkatDesa()
    {
        return $this->role === 'perangkat_desa';
    }
}