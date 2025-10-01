<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_aksi_konvergensis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kartu_keluarga_id');
            $table->unsignedBigInteger('kelurahan_id');
            $table->unsignedBigInteger('created_by');
            $table->string('status')->default('pending');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('original_aksi_konvergensi_id')->nullable();
            $table->string('nama_aksi');
            $table->boolean('selesai')->default(false);
            $table->integer('tahun');
            $table->string('foto')->nullable();
            $table->string('air_bersih_sanitasi')->nullable();
            $table->string('akses_layanan_kesehatan_kb')->nullable();
            $table->string('pendidikan_pengasuhan_ortu')->nullable();
            $table->string('edukasi_kesehatan_remaja')->nullable();
            $table->string('kesadaran_pengasuhan_gizi')->nullable();
            $table->string('akses_pangan_bergizi')->nullable();
            $table->string('makanan_ibu_hamil')->nullable();
            $table->string('tablet_tambah_darah')->nullable();
            $table->string('inisiasi_menyusui_dini')->nullable();
            $table->string('asi_eksklusif')->nullable();
            $table->string('asi_mpasi')->nullable();
            $table->string('imunisasi_lengkap')->nullable();
            $table->string('pencegahan_infeksi')->nullable();
            $table->string('status_gizi_ibu')->nullable();
            $table->string('penyakit_menular')->nullable();
            $table->string('jenis_penyakit')->nullable();
            $table->string('kesehatan_lingkungan')->nullable();
            $table->text('narasi')->nullable();
            $table->string('pelaku_aksi')->nullable();
            $table->dateTime('waktu_pelaksanaan')->nullable();
            $table->timestamps();

            $table->foreign('kartu_keluarga_id')->references('id')->on('kartu_keluargas')->onDelete('cascade');
            $table->foreign('kelurahan_id')->references('id')->on('kelurahans')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('original_aksi_konvergensi_id')->references('id')->on('aksi_konvergensis')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_aksi_konvergensis');
    }
};