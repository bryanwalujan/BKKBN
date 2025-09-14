<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class tambahkecamatan extends Migration
{
    public function up()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->unsignedBigInteger('kecamatan_id')->nullable()->after('id');
            $table->unsignedBigInteger('kelurahan_id')->nullable()->after('kecamatan_id');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('set null');
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('set null');
            $table->dropColumn('kelurahan');
        });
    }

    public function down()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->string('kelurahan', 100)->after('nama');
            $table->dropForeign(['kecamatan_id']);
            $table->dropForeign(['kelurahan_id']);
            $table->dropColumn('kecamatan_id');
            $table->dropColumn('kelurahan_id');
        });
    }
}