<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('pending_balitas', function (Blueprint $table) {
            $table->bigInteger('original_balita_id')->unsigned()->nullable()->after('created_by');
            $table->foreign('original_balita_id')->references('id')->on('balitas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('pending_balitas', function (Blueprint $table) {
            $table->dropForeign(['original_balita_id']);
            $table->dropColumn('original_balita_id');
        });
    }
};