<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToRemajaPutrisTable extends Migration
{
    public function up()
    {
        Schema::table('remaja_putris', function (Blueprint $table) {
            $table->unsignedBigInteger('kartu_keluarga_id')->nullable()->after('nama');
            $table->unsignedBigInteger('kecamatan_id')->nullable()->after('kartu_keluarga_id');
            $table->unsignedBigInteger('kelurahan_id')->nullable()->after('kecamatan_id');

            $table->foreign('kartu_keluarga_id')->references('id')->on('kartu_keluargas')->onDelete('set null');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('set null');
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('remaja_putris', function (Blueprint $table) {
            $table->dropForeign(['kartu_keluarga_id']);
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['kelurahan_id']);
            $table->dropColumn(['kartu_keluarga_id', 'kecamatan_id', 'kelurahan_id']);
        });
    }
}