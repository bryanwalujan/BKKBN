<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RemajaPutri extends Model
{
    protected $fillable = [
        'nama',
        'sekolah',
        'kelas',
        'umur',
        'status_anemia',
        'konsumsi_ttd',
        'foto',
    ];
}