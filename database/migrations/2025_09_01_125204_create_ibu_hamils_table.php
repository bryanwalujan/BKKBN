<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ibu_hamils', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->string('kelurahan', 255);
            $table->string('kecamatan', 255);
            $table->enum('trimester', ['Trimester 1', 'Trimester 2', 'Trimester 3']);
            $table->enum('intervensi', ['Tidak Ada', 'Gizi', 'Konsultasi Medis', 'Lainnya']);
            $table->enum('status_gizi', ['Normal', 'Kurang Gizi', 'Berisiko']);
            $table->enum('warna_status_gizi', ['Sehat', 'Waspada', 'Bahaya']);
            $table->integer('usia_kehamilan');
            $table->decimal('berat', 5, 1);
            $table->decimal('tinggi', 5, 1);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ibu_hamils');
    }
};