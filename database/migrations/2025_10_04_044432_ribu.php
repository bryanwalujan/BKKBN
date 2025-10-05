<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ibus', function (Blueprint $table) {
            $table->string('tempat_lahir', 255)->nullable()->after('nama');
            $table->string('nomor_telepon', 255)->nullable()->after('tempat_lahir');
            $table->unsignedInteger('jumlah_anak')->nullable()->after('nomor_telepon');
        });
    }

    public function down()
    {
        Schema::table('ibus', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'nomor_telepon', 'jumlah_anak']);
        });
    }
};