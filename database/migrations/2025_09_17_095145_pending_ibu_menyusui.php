<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pending_ibu_menyusuis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pending_ibu_id')->constrained('pending_ibus')->onDelete('cascade');
            $table->enum('status_menyusui', ['Eksklusif', 'Non-Eksklusif']);
            $table->integer('frekuensi_menyusui');
            $table->string('kondisi_ibu');
            $table->enum('warna_kondisi', ['Hijau (success)', 'Kuning (warning)', 'Merah (danger)']);
            $table->decimal('berat', 5, 1);
            $table->decimal('tinggi', 5, 1);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->enum('status_verifikasi', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pending_ibu_menyusuis');
    }
};