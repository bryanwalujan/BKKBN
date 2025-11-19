<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataRiset extends Model
{
    protected $fillable = [
        'judul',
        'angka',
        'is_realtime',
        'tanggal_update',
    ];

    protected $casts = [
        'is_realtime' => 'boolean',
        'tanggal_update' => 'datetime',
    ];
}