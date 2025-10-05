<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ibu_nifas', function (Blueprint $table) {
            $table->string('tanggal_melahirkan', 255)->nullable()->after('hari_nifas');
            $table->string('tempat_persalinan', 255)->nullable()->after('tanggal_melahirkan');
            $table->string('penolong_persalinan', 255)->nullable()->after('tempat_persalinan');
            $table->string('cara_persalinan', 255)->nullable()->after('penolong_persalinan');
            $table->string('komplikasi', 255)->nullable()->after('cara_persalinan');
            $table->string('keadaan_bayi', 255)->nullable()->after('komplikasi');
            $table->string('kb_pasca_salin', 255)->nullable()->after('keadaan_bayi');
        });
    }

    public function down()
    {
        Schema::table('ibu_nifas', function (Blueprint $table) {
            $table->dropColumn([
                'tanggal_melahirkan',
                'tempat_persalinan',
                'penolong_persalinan',
                'cara_persalinan',
                'komplikasi',
                'keadaan_bayi',
                'kb_pasca_salin'
            ]);
        });
    }
};