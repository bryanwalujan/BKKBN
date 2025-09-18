<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingIbuHamil extends Model
{
    protected $table = 'pending_ibu_hamil';
    protected $fillable = [
        'pending_ibu_id',
        'trimester',
        'intervensi',
        'status_gizi',
        'warna_status_gizi',
        'usia_kehamilan',
        'berat',
        'tinggi',
        'created_by',
        'status_verifikasi',
        'original_ibu_hamil_id',
    ];

    public function pendingIbu()
    {
        return $this->belongsTo(PendingIbu::class, 'pending_ibu_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}