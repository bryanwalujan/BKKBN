<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_ibus', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->nullable()->unique();
            $table->string('nama');
            $table->foreignId('kecamatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluargas')->onDelete('cascade');
            $table->text('alamat')->nullable();
            $table->enum('status', ['Hamil', 'Nifas', 'Menyusui', 'Tidak Aktif'])->default('Tidak Aktif');
            $table->string('foto')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('original_ibu_id')->nullable();
            $table->foreign('original_ibu_id')->references('id')->on('ibus')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_ibus');
    }
};