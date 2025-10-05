<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ibu_hamils', function (Blueprint $table) {
            $table->string('tinggi_fundus_uteri', 255)->nullable()->after('usia_kehamilan');
            $table->string('imt', 255)->nullable()->after('tinggi_fundus_uteri');
            $table->string('riwayat_penyakit', 255)->nullable()->after('imt');
            $table->string('kadar_hb', 255)->nullable()->after('riwayat_penyakit');
            $table->string('lingkar_kepala', 255)->nullable()->after('kadar_hb');
            $table->string('taksiran_berat_janin', 255)->nullable()->after('lingkar_kepala');
        });
    }

    public function down()
    {
        Schema::table('ibu_hamils', function (Blueprint $table) {
            $table->dropColumn([
                'tinggi_fundus_uteri',
                'imt',
                'riwayat_penyakit',
                'kadar_hb',
                'lingkar_kepala',
                'taksiran_berat_janin'
            ]);
        });
    }
};