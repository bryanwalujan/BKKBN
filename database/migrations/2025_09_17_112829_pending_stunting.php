<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_stuntings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_keluarga_id')->constrained()->onDelete('cascade');
            $table->string('nik')->nullable()->unique();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('berat_tinggi');
            $table->foreignId('kecamatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained()->onDelete('cascade');
            $table->enum('status_gizi', ['Sehat', 'Stunting', 'Kurang Gizi', 'Obesitas']);
            $table->enum('warna_gizi', ['Sehat', 'Waspada', 'Bahaya']);
            $table->string('tindak_lanjut')->nullable();
            $table->enum('warna_tindak_lanjut', ['Sehat', 'Waspada', 'Bahaya']);
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_stuntings');
    }
};