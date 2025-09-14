<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('edukasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->index();
            $table->text('penyebaran_informasi_media')->nullable();
            $table->text('konseling_perubahan_perilaku')->nullable();
            $table->text('konseling_pengasuhan')->nullable();
            $table->text('paud')->nullable();
            $table->text('konseling_kesehatan_reproduksi')->nullable();
            $table->text('ppa')->nullable();
            $table->text('modul_buku_saku')->nullable();
            $table->string('gambar')->nullable();
            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('edukasi');
    }
};