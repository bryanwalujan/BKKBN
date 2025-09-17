<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_remaja_putris', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->foreignId('kartu_keluarga_id')->constrained()->onDelete('cascade');
            $table->foreignId('kecamatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained()->onDelete('cascade');
            $table->string('sekolah');
            $table->string('kelas');
            $table->integer('umur');
            $table->enum('status_anemia', ['Tidak Anemia', 'Anemia Ringan', 'Anemia Sedang', 'Anemia Berat']);
            $table->enum('konsumsi_ttd', ['Rutin', 'Tidak Rutin', 'Tidak Konsumsi']);
            $table->string('foto')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_remaja_putris');
    }
};