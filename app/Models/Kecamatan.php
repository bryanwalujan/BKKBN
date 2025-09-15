<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $table = 'kecamatans';
    protected $fillable = ['nama_kecamatan'];

    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class, 'kecamatan_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}