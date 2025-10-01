<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingIbuMenyusui extends Model
{
    protected $table = 'pending_ibu_menyusuis';
    protected $fillable = [
        'pending_ibu_id',
        'status_menyusui',
        'frekuensi_menyusui',
        'kondisi_ibu',
        'warna_kondisi',
        'berat',
        'tinggi',
        'created_by',
        'status_verifikasi',
    ];

    public function pendingIbu()
    {
        return $this->belongsTo(PendingIbu::class, 'pending_ibu_id');
    }
}