<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingRemajaPutri extends Model
{
    protected $table = 'pending_remaja_putris';

    protected $fillable = [
        'nama',
        'kartu_keluarga_id',
        'kecamatan_id',
        'kelurahan_id',
        'sekolah',
        'kelas',
        'umur',
        'status_anemia',
        'konsumsi_ttd',
        'foto',
        'status',
        'created_by',
        'original_remaja_putri_id',
    ];

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}