<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bayi_baru_lahir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_nifas_id')->constrained('ibu_nifas')->onDelete('cascade');
            $table->string('umur_dalam_kandungan', 255)->nullable();
            $table->string('berat_badan_lahir', 255)->nullable();
            $table->string('panjang_badan_lahir', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bayi_baru_lahir');
    }
};