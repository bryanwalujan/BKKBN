<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pendamping_keluargas', function (Blueprint $table) {
            // Drop existing columns
            $table->dropColumn(['kelurahan', 'kecamatan']);
            
            // Add new foreign key columns
            $table->foreignId('kelurahan_id')->constrained()->onDelete('restrict');
            $table->foreignId('kecamatan_id')->constrained()->onDelete('restrict');
            
            // Add new activity columns
            $table->boolean('penyuluhan')->default(false);
            $table->string('penyuluhan_frekuensi')->nullable();
            $table->boolean('rujukan')->default(false);
            $table->string('rujukan_frekuensi')->nullable();
            $table->boolean('kunjungan_krs')->default(false);
            $table->string('kunjungan_krs_frekuensi')->nullable();
            $table->boolean('pendataan_bansos')->default(false);
            $table->string('pendataan_bansos_frekuensi')->nullable();
            $table->boolean('pemantauan_kesehatan')->default(false);
            $table->string('pemantauan_kesehatan_frekuensi')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pendamping_keluargas', function (Blueprint $table) {
            $table->dropForeign(['kelurahan_id', 'kecamatan_id']);
            $table->dropColumn([
                'kelurahan_id',
                'kecamatan_id',
                'penyuluhan',
                'penyuluhan_frekuensi',
                'rujukan',
                'rujukan_frekuensi',
                'kunjungan_krs',
                'kunjungan_krs_frekuensi',
                'pendataan_bansos',
                'pendataan_bansos_frekuensi',
                'pemantauan_kesehatan',
                'pemantauan_kesehatan_frekuensi',
            ]);
            $table->string('kelurahan');
            $table->string('kecamatan');
        });
    }
};