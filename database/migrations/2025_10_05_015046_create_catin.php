<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catins', function (Blueprint $table) {
            $table->id();
            $table->date('hari_tanggal')->nullable();
            $table->string('catin_wanita_nama', 255)->nullable();
            $table->string('catin_wanita_nik', 255)->nullable();
            $table->string('catin_wanita_tempat_lahir', 255)->nullable();
            $table->date('catin_wanita_tgl_lahir')->nullable();
            $table->string('catin_wanita_no_hp', 255)->nullable();
            $table->text('catin_wanita_alamat')->nullable();
            $table->string('catin_pria_nama', 255)->nullable();
            $table->string('catin_pria_nik', 255)->nullable();
            $table->string('catin_pria_tempat_lahir', 255)->nullable();
            $table->date('catin_pria_tgl_lahir')->nullable();
            $table->string('catin_pria_no_hp', 255)->nullable();
            $table->text('catin_pria_alamat')->nullable();
            $table->date('tanggal_pernikahan')->nullable();
            $table->decimal('berat_badan', 5, 1)->nullable();
            $table->decimal('tinggi_badan', 5, 1)->nullable();
            $table->decimal('imt', 5, 1)->nullable();
            $table->decimal('kadar_hb', 5, 1)->nullable();
            $table->enum('merokok', ['Ya', 'Tidak'])->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catins');
    }
};
