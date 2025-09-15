<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPendamping extends Model
{
    protected $table = 'laporan_pendamping';
    protected $fillable = [
        'pendamping_keluarga_id',
        'kartu_keluarga_id',
        'laporan',
        'dokumentasi',
        'tanggal_laporan',
    ];

    public function pendampingKeluarga()
    {
        return $this->belongsTo(PendampingKeluarga::class);
    }

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }
}