<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_ibu_nifas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pending_ibu_id')->nullable()->constrained('pending_ibus')->onDelete('cascade');
            $table->foreignId('ibu_id')->nullable()->constrained('ibus')->onDelete('cascade');
            $table->integer('hari_nifas');
            $table->enum('kondisi_kesehatan', ['Normal', 'Butuh Perhatian', 'Kritis']);
            $table->enum('warna_kondisi', ['Hijau (success)', 'Kuning (warning)', 'Merah (danger)']);
            $table->decimal('berat', 5, 1);
            $table->decimal('tinggi', 5, 1);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('original_ibu_nifas_id')->nullable()->constrained('ibu_nifas')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_ibu_nifas');
    }
};