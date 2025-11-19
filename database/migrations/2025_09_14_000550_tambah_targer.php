<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class tambahTarger extends Migration
{
    public function up()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->text('target')->nullable()->after('kategori');
        });
    }

    public function down()
    {
        Schema::table('data_monitorings', function (Blueprint $table) {
            $table->dropColumn('target');
        });
    }
}