<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendampingKeluarga extends Model
{
    protected $fillable = [
        'nama',
        'peran',
        'kelurahan',
        'kecamatan',
        'status',
        'tahun_bergabung',
        'foto',
    ];
}