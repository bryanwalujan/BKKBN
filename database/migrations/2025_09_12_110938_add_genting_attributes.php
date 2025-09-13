<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGentingAttributes extends Migration
{
    public function up()
    {
        Schema::table('gentings', function (Blueprint $table) {
            $table->text('narasi')->nullable()->after('jenis_intervensi');
        });
    }

    public function down()
    {
        Schema::table('gentings', function (Blueprint $table) {
            $table->dropColumn('narasi');
        });
    }
}