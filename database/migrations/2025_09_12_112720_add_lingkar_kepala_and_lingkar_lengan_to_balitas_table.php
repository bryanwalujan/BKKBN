<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLingkarKepalaAndLingkarLenganToBalitasTable extends Migration
{
    public function up()
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->decimal('lingkar_kepala', 5, 1)->nullable()->after('berat_tinggi');
            $table->decimal('lingkar_lengan', 5, 1)->nullable()->after('lingkar_kepala');
        });
    }

    public function down()
    {
        Schema::table('balitas', function (Blueprint $table) {
            $table->dropColumn(['lingkar_kepala', 'lingkar_lengan']);
        });
    }
}