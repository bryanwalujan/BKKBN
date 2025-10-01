<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_data_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('target');
            $table->foreignId('kecamatan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained()->onDelete('cascade');
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluargas')->onDelete('cascade');
            $table->foreignId('ibu_id')->nullable()->constrained('ibus')->onDelete('set null');
            $table->foreignId('balita_id')->nullable()->constrained('balitas')->onDelete('set null');
            $table->string('nama');
            $table->string('kategori');
            $table->text('perkembangan_anak')->nullable();
            $table->boolean('kunjungan_rumah')->nullable();
            $table->string('frekuensi_kunjungan')->nullable();
            $table->boolean('pemberian_pmt')->nullable();
            $table->string('frekuensi_pmt')->nullable();
            $table->string('status');
            $table->string('warna_badge');
            $table->date('tanggal_monitoring');
            $table->integer('urutan');
            $table->boolean('status_aktif');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan')->nullable();
            $table->foreignId('original_id')->nullable()->constrained('data_monitorings')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_data_monitorings');
    }
};