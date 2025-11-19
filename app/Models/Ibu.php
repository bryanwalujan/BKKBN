<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Ibu extends Model
{
    protected $table = 'ibus';
    protected $fillable = [
        'nik',
        'nama',
        'tempat_lahir',
        'nomor_telepon',
        'jumlah_anak',
        'kecamatan_id',
        'kelurahan_id',
        'kartu_keluarga_id',
        'alamat',
        'status',
        'foto',
        'created_by',
    ];

    // Accessor untuk mendekripsi NIK
    public function getNikAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Gagal mendekripsi NIK: ' . $e->getMessage(), ['nik' => $value]);
            return null;
        }
    }

    // Mutator untuk mengenkripsi NIK
    public function setNikAttribute($value)
    {
        $this->attributes['nik'] = $value ? Crypt::encryptString($value) : null;
    }

    // Accessor untuk mendekripsi Nomor Telepon
    public function getNomorTeleponAttribute($value)
    {
        try {
            return $value ? Crypt::decryptString($value) : null;
        } catch (\Exception $e) {
            \Log::error('Gagal mendekripsi Nomor Telepon: ' . $e->getMessage(), ['nomor_telepon' => $value]);
            return null;
        }
    }

    // Mutator untuk mengenkripsi Nomor Telepon
    public function setNomorTeleponAttribute($value)
    {
        $this->attributes['nomor_telepon'] = $value ? Crypt::encryptString($value) : null;
    }

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class, 'kartu_keluarga_id');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function ibuHamil()
    {
        return $this->hasOne(IbuHamil::class, 'ibu_id');
    }

    public function ibuNifas()
    {
        return $this->hasOne(IbuNifas::class, 'ibu_id');
    }

    public function ibuMenyusui()
    {
        return $this->hasOne(IbuMenyusui::class, 'ibu_id');
    }
}