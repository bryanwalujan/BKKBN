<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('ibu_nifas', function (Blueprint $table) {
            $table->date('tanggal_melahirkan')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('ibu_nifas', function (Blueprint $table) {
            $table->string('tanggal_melahirkan', 255)->nullable()->change();
        });
    }
};