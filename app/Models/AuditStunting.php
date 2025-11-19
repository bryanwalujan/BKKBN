<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditStunting extends Model
{
    protected $table = 'audit_stuntings';
    protected $fillable = [
        'data_monitoring_id',
        'user_id',
        'foto_dokumentasi',
        'pihak_pengaudit',
        'laporan',
        'narasi',
        'created_by',
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