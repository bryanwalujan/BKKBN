<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_gentings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kartu_keluarga_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('original_genting_id')->nullable();
            $table->string('catatan')->nullable();
            $table->string('nama_kegiatan');
            $table->date('tanggal');
            $table->string('lokasi');
            $table->string('sasaran');
            $table->string('jenis_intervensi');
            $table->text('narasi')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->enum('dunia_usaha', ['ada', 'tidak'])->nullable();
            $table->string('dunia_usaha_frekuensi')->nullable();
            $table->enum('pemerintah', ['ada', 'tidak'])->nullable();
            $table->string('pemerintah_frekuensi')->nullable();
            $table->enum('bumn_bumd', ['ada', 'tidak'])->nullable();
            $table->string('bumn_bumd_frekuensi')->nullable();
            $table->enum('individu_perseorangan', ['ada', 'tidak'])->nullable();
            $table->string('individu_perseorangan_frekuensi')->nullable();
            $table->enum('lsm_komunitas', ['ada', 'tidak'])->nullable();
            $table->string('lsm_komunitas_frekuensi')->nullable();
            $table->enum('swasta', ['ada', 'tidak'])->nullable();
            $table->string('swasta_frekuensi')->nullable();
            $table->enum('perguruan_tinggi_akademisi', ['ada', 'tidak'])->nullable();
            $table->string('perguruan_tinggi_akademisi_frekuensi')->nullable();
            $table->enum('media', ['ada', 'tidak'])->nullable();
            $table->string('media_frekuensi')->nullable();
            $table->enum('tim_pendamping_keluarga', ['ada', 'tidak'])->nullable();
            $table->string('tim_pendamping_keluarga_frekuensi')->nullable();
            $table->enum('tokoh_masyarakat', ['ada', 'tidak'])->nullable();
            $table->string('tokoh_masyarakat_frekuensi')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_gentings');
    }
};