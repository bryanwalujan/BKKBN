<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingAuditStunting extends Model
{
    protected $fillable = [
        'data_monitoring_id',
        'user_id',
        'foto_dokumentasi',
        'pihak_pengaudit',
        'laporan',
        'narasi',
        'status_verifikasi',
        'catatan',
        'created_by',
        'original_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function dataMonitoring()
    {
        return $this->belongsTo(DataMonitoring::class, 'data_monitoring_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}