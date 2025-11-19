<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Stunting;

class RemoveStringKecamatanKelurahanFromStuntings extends Migration
{
    public function up()
    {
        // Pindahkan data dari kolom string ke kolom ID
        Stunting::all()->each(function ($stunting) {
            if ($stunting->kecamatan && !$stunting->kecamatan_id) {
                $kecamatan = Kecamatan::where('nama_kecamatan', $stunting->kecamatan)->first();
                if ($kecamatan) {
                    $stunting->kecamatan_id = $kecamatan->id;
                }
            }
            if ($stunting->kelurahan && !$stunting->kelurahan_id) {
                $kelurahan = Kelurahan::where('nama_kelurahan', $stunting->kelurahan)->first();
                if ($kelurahan) {
                    $stunting->kelurahan_id = $kelurahan->id;
                }
            }
            $stunting->save();
        });

        // Hapus kolom string
        Schema::table('stuntings', function (Blueprint $table) {
            $table->dropColumn(['kecamatan', 'kelurahan']);
        });
    }

    public function down()
    {
        // Tambahkan kembali kolom string jika rollback
        Schema::table('stuntings', function (Blueprint $table) {
            $table->string('kecamatan', 255)->after('berat_tinggi')->nullable();
            $table->string('kelurahan', 255)->after('kecamatan')->nullable();
        });

        // Kembalikan data dari ID ke string
        Stunting::all()->each(function ($stunting) {
            if ($stunting->kecamatan_id) {
                $kecamatan = Kecamatan::find($stunting->kecamatan_id);
                $stunting->kecamatan = $kecamatan ? $kecamatan->nama_kecamatan : null;
            }
            if ($stunting->kelurahan_id) {
                $kelurahan = Kelurahan::find($stunting->kelurahan_id);
                $stunting->kelurahan = $kelurahan ? $kelurahan->nama_kelurahan : null;
            }
            $stunting->save();
        });
    }
}