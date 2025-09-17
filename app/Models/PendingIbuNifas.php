<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingIbuNifas extends Model
{
    protected $table = 'pending_ibu_nifas';
    protected $fillable = [
        'pending_ibu_id',
        'ibu_id',
        'hari_nifas',
        'kondisi_kesehatan',
        'warna_kondisi',
        'berat',
        'tinggi',
        'created_by',
        'status_verifikasi',
        'original_ibu_nifas_id',
    ];

    public function pendingIbu()
    {
        return $this->belongsTo(PendingIbu::class, 'pending_ibu_id');
    }

    public function ibu()
    {
        return $this->belongsTo(Ibu::class, 'ibu_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}