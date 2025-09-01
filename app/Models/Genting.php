<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genting extends Model
{
    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'lokasi',
        'sasaran',
        'jenis_intervensi',
        'dokumentasi',
    ];

    protected $dates = ['tanggal'];
}