<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TambahIbu extends Migration
{
    public function up(): void
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->bigInteger('ibu_id')->unsigned()->nullable()->after('kartu_keluarga_id');
            $table->bigInteger('balita_id')->unsigned()->nullable()->after('ibu_id');
            $table->foreign('ibu_id')->references('id')->on('ibus')->onDelete('set null');
            $table->foreign('balita_id')->references('id')->on('balitas')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->dropForeign(['ibu_id']);
            $table->dropForeign(['balita_id']);
            $table->dropColumn(['ibu_id', 'balita_id']);
        });
    }
};