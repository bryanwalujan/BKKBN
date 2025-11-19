<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laporan_pendamping', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pendamping_keluarga_id')->constrained('pendamping_keluargas')->onDelete('cascade');
            $table->foreignId('kartu_keluarga_id')->constrained()->onDelete('cascade');
            $table->text('laporan');
            $table->string('dokumentasi')->nullable();
            $table->date('tanggal_laporan');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laporan_pendamping');
    }
};