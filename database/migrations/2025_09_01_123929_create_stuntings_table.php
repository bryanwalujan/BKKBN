<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stuntings', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('berat_tinggi', 50);
            $table->string('kelurahan', 255);
            $table->string('kecamatan', 255);
            $table->string('status_gizi', 255);
            $table->enum('warna_gizi', ['Sehat', 'Waspada', 'Bahaya']);
            $table->string('tindak_lanjut')->nullable();
            $table->enum('warna_tindak_lanjut', ['Sehat', 'Waspada', 'Bahaya']);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stuntings');
    }
};