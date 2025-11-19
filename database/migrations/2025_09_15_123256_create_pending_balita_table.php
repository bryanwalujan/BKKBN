<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pending_balitas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kartu_keluarga_id')->nullable();
            $table->string('nik', 255)->nullable();
            $table->string('nama', 255);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->unsignedBigInteger('kecamatan_id');
            $table->unsignedBigInteger('kelurahan_id');
            $table->string('berat_tinggi', 255);
            $table->decimal('lingkar_kepala', 5, 1)->nullable();
            $table->decimal('lingkar_lengan', 5, 1)->nullable();
            $table->string('alamat', 255)->nullable();
            $table->enum('status_gizi', ['Sehat', 'Stunting', 'Kurang Gizi', 'Obesitas']);
            $table->enum('warna_label', ['Sehat', 'Waspada', 'Bahaya']);
            $table->string('status_pemantauan', 255)->nullable();
            $table->string('foto', 255)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('kartu_keluarga_id')->references('id')->on('kartu_keluargas')->onDelete('set null');
            $table->foreign('kecamatan_id')->references('id')->on('kecamatans')->onDelete('cascade');
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pending_balitas');
    }
};